FROM kyma/docker-nginx

ADD web/ /var/www

COPY nginx.conf /etc/nginx/sites-enabled/default

CMD 'nginx'