FROM ubuntu:latest
MAINTAINER docker@ekito.fr

RUN apt-get update && apt-get -y install cron && apt-get -y install curl

# Copy cron file to the cron.d directory
COPY cron/cron-cars /etc/cron.d/cron-cars

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/cron-cars

# Apply cron job
RUN crontab /etc/cron.d/cron-cars

# Create the log file to be able to run tail
RUN touch /var/log/cron.log

# Run the command on container startup
CMD cron && tail -f /var/log/cron.log
