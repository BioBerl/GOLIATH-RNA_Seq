#!/usr/bin/env bash
#filename:ver0.1.sh
PATH="/home/users/dberl/projects_current/VER01/scripts/:$PATH"

dir=$1

if [[ -z "$dir" ]]; then
	echo "Usage: $0 DIR"
	exit 0
fi

if [[ ! -d "$dir" ]]; then
	echo "'$dir' is not a valid directory" >&2
	exit 1
fi

echo $dir >&2
cd $dir

source "JOB"

email() {

	cat<<EOF  > message.txt
To: "$EMAIL" 
From: "$EMAIL"
Subject: Results of GOLIATH

EOF

# >&2 eh um streamer, um arquivo que contem o std error de saida.   
        echo ":: Send e-mail to $EMAIL" >&2                   
	ssmtp "$EMAIL" < message.txt
}

verify_fastq() {

	paste  <(zcat $FASTQ1) <(zcat $FASTQ2)   | awk '(NR%4)==1 {print}' | sed 's/\/.//g' | awk 'BEGIN{OFS=FS="\t"} ($1 != $2){print "ERROR,NOT A FASTQ PAIRED-END FILE"}'
}

run() {
if [[ "$TYPE" == "single" ]]; then
	echo ":: Validating '$FASTQ1' ..." >&2
	if ! zcat "$FASTQ1" |fqvalidator ; then 
		echo "'$FASTQ1' is not a valid FASTQ file" >&2
		exit 1
	fi 	

	echo ":: Run kallisto on  single-end '$FASTQ1' ..." >&2
	kauto_single "$FASTQ1" "$OUTNAME"
 
elif [[ "$TYPE" == "paired" ]]; then
	echo ":: Validating '$FASTQ1' ..." >&2
	if ! zcat "$FASTQ1" |fqvalidator ; then 
		echo "'$FASTQ1' is not a valid FASTQ file" >&2
		exit 1
	fi 	

	echo ":: Validating '$FASTQ2' ..." >&2
	if ! zcat "$FASTQ1" |fqvalidator ; then 
		echo "'$FASTQ2' is not a valid FASTQ file" >&2
		exit 1
	fi

	echo ":: Run kallisto paired '$FASTQ1' '$FASTQ2' ..." >&2
	kauto_paired "$FASTQ1" "$FASTQ2" "$OUTNAME" 2> kallisto.log 
else
	echo "no type input from web_interface"
fi

}
#  Ainda falta fazer um verificador de paired end mais completo e menos propenso a erros do que esse daqui ...

# fazer uma funcao pra enviar email , daniel sugeriu...
# preciso passar o nome do arquivo de output. 

cpaws() {
	EXP_DATE=`date -d "+60 days" +"%Y-%m-%dT23:59:00Z"`
	echo ":: Copy the output to AWS" >&2
        aws s3 cp  "$OUTNAME"  --acl public-read --expires "$EXP_DATE" --recursive
}

run
cpaws
email

