FROM alpine:3.12

RUN apk add --update --no-cache nginx

COPY nginx.conf /etc/nginx/
ADD api.conf /etc/nginx/conf.d/default.conf

RUN apk add --update --no-cache \
    bash

RUN adduser -D -g '' -G www-data www-data

CMD ["nginx"]

EXPOSE 80
EXPOSE 443