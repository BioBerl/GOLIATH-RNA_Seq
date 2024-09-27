#!/usr/bin/env perl

########################################################
#         FILE: Zord.pl
#        USAGE: Zord.pl
#  DESCRIPTION: 
#      OPTIONS: --- 
# REQUIREMENTS: --- 
#         BUGS: --- 
#        NOTES: --- 
#       AUTHOR: Daniel Takatori Ohara 
#      COMPANY: Bioinformatics Lab - Hospital Sirio Libanes 
#      VERSION: 1.0 
#      CREATED: Wed Jun  5 10:47:11 -03 2019 
#     REVISION: --- 
#      LICENSE: GPL 
########################################################

use strict;
use warnings;

use DBI;

&main();

sub main() {
	#Insert here the code#

    my $dbh = "";
    my $name = 0;
    $dbh = &connectdb();
    while(1) {
        $name = &query_search($dbh);
        if($name) {
            system("ver0.1.sh ".$name);
            sleep(10);
            &query_update($dbh, $name);
        }
    }

    $dbh->disconnect();
}

sub query_update() {
    my @args = @_;

    my $sql = "UPDATE process SET status = '2' WHERE name = ?;";

    my $sth = $args[0]->prepare($sql);

    $sth->execute($args[1]);

}

sub query_search() {
    my @args = @_;

    my @names = ();
    my $sth = $args[0]->prepare("SELECT DISTINCT name FROM process WHERE status = '1' LIMIT 1;");

    $sth->execute();
    if($sth->rows()) {
        @names = $sth->fetchrow_array();
        foreach my $name (@names) {
            return $name;
        }
    } else {
        return 0;
    }
}

sub connectdb() {

    my $user = $ENV{'USERDB'};
    my $pass = $ENV{'PASSDB'};
    my $host = $ENV{'HOSTDB'};
    my $db   = $ENV{'DB'};

    my $dbh = DBI->connect("DBI:mysql:host=$host;database=$db","$user", "$pass");

    return $dbh;
}
