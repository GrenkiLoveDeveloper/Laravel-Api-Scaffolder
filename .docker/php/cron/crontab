FROM lara-app:local

USER $user

RUN apk update --verbose && apk --no-cache add \
    dcron

COPY /crontab /etc/crontabs/root
RUN chmod 0644 /etc/crontabs/root

RUN touch /var/log/cron.log

CMD ["sh", "-c", "crond -f -l 2 && tail -f /var/log/cron.log"]
