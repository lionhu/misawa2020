FROM python:3.7.3
LABEL maintainer Lionhu
ENV PYTHONUNBUFFERED 1


RUN apt-get update && apt-get install -y nginx supervisor vim

# COPY /system/nginx/nginx.conf /etc/nginx/nginx.conf
# COPY /system/nginx/my_nginx.conf /etc/nginx/sites-available/
# RUN mkdir -p /etc/nginx/sites-enabled/\
#     && ln -s /etc/nginx/sites-available/nginx_laravel.conf /etc/nginx/sites-enabled/

RUN mkdir -p /etc/supervisor/logs/
COPY /system/nginx/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN mkdir /django_project
WORKDIR /django_project

COPY /project/requirements.txt /django_project/requirements.txt
RUN pip install -r requirements.txt


RUN apt-get install -y gnupg
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs npm
RUN npm install n -g
RUN n stable
RUN apt purge -y nodejs npm

RUN mkdir -p /django_project/vue_project
WORKDIR /django_project/vue_project 
COPY /project/vue_project /django_project/vue_project

RUN npm install --save-dev webpack webpack-cli @vue/cli @webpack-cli/init -g
RUN npm install --save-dev style-loader css-loader sass-loader
RUN npm install --save vue
# RUN npm install 

WORKDIR /django_project

CMD ["/usr/bin/supervisord", "-c","/etc/supervisor/conf.d/supervisord.conf"]
