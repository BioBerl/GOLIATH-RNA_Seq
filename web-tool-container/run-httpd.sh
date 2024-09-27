#!/bin/bash

# Make sure we're not confused by old, incompletely-shutdown httpd
# context after restarting the container.  httpd won't start correctly
# if it thinks it is already running.
rm -rf /run/httpd/* /tmp/httpd*

#exec /usr/local/bin/gitfile.sh git@bitbucket.org:danielohara/dberl.git /var/www/html/ && /usr/sbin/apachectl -DFOREGROUND
exec /usr/sbin/apachectl -DFOREGROUND
