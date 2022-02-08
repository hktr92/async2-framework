FROM nginx:1.21.5-alpine AS nginx-base

RUN rm -rf /etc/nginx/conf.d
COPY docker/nginx/config /etc/nginx/

ENV PHP_FPM_URL=${PHP_FPM_URL:-localhost:9000}
ENV HSTS_HEADER=${HSTS_HEADER:-}
ENV PERMISSION_POLICY_HEADER=${PERMISSION_POLICY_HEADER:-geolocation=(self),microphone=(),camera=(),fullscreen=(),accelerometer=(),autoplay=()}

FROM nginx-base AS nginx-dev

FROM nginx-base AS nginx-prod

COPY public/ /app/public/
