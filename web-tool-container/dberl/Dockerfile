FROM centos/httpd:latest

MAINTAINER Daniel Takatori Ohara <dtohara@gmail.com>

ENV container docker

LABEL architecture="x86_64" \
      name="dberl/tool"

RUN yum update -y

###Install PHP 7.3###
RUN yum install -y https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
RUN yum install -y http://rpms.remirepo.net/enterprise/remi-release-7.rpm
RUN yum install -y yum-utils vim
RUN yum-config-manager --enable remi-php73
RUN yum install -y php php-mcrypt php-cli php-gd php-curl php-mysql php-ldap php-zip php-fileinfo

###Install 
