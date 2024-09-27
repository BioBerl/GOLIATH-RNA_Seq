FROM ubuntu:latest

MAINTAINER Daniel Takatori Ohara <dtohara@gmail.com>

ENV container docker

###Configuraçoes banco###
ENV DB db_goliath

###Configuracoes AWS###
ENV AWS_DEFAULT_REGION sa-east-1

###Configuracoes ZORD###
ENV ZORD_WORK_DIR "/WD"
ENV ZORD_LOG_FILE "/WD/testing.log"
#a queue eh a fila pra rodar o kallisto em sequencia ou a pipeline como um todo ? DAVID vc mesmo consegue responder essa pergunta ....
ENV ZORD_MAX_QUEUE 2
ENV INDEX "/IDX/gen29.idx"


LABEL architecture="x86_64" \
      name="dberl/tool/Zord/Perl"

RUN apt-get -y update && apt-get -y upgrade
RUN apt-get -y install libmysqlclient-dev perl git cmake make libhdf5-dev build-essential g++ automake autoconf gawk
RUN cpan install Devel::CheckLib
RUN cpan install DBI DBD:mysql

###Configure SSMTP
RUN apt-get -y install ssmtp
COPY ssmtp/revaliases /etc/ssmtp/revaliases
COPY ssmtp/ssmtp.conf /etc/ssmtp/ssmtp.conf

###Install AWS Cli###
RUN apt-get -y install python3-pip
RUN pip3 install awscli --upgrade

###Install kallisto####
RUN cd /tmp/ && git clone https://github.com/pachterlab/kallisto.git 
RUN cd /tmp/kallisto && mkdir build && cd build && cmake .. && make && make install

###Copiando scripts David###
COPY scripts/abu_genes /usr/local/bin/abu_genes
COPY scripts/abu_transcripts /usr/local/bin/abu_transcripts
COPY scripts/fqvalidator /usr/local/bin/fqvalidator
COPY scripts/kauto_paired /usr/local/bin/kauto_paired
COPY scripts/kauto_single /usr/local/bin/kauto_single
COPY scripts/parse_gtf_enhance_tsvs /usr/local/bin/parse_gtf_enhance_tsvs
COPY scripts/RBMOD.R /usr/local/bin/RBMOD.R
COPY scripts/ver0.1.sh /usr/local/bin/ver0.1.sh

COPY Zord.pl /app/Zord.pl

WORKDIR /WD
