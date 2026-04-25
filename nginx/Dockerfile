FROM nginx:alpine AS base

# Development stage - files mounted via volumes
FROM base AS development

# Production stage - files baked into image
FROM base AS production

COPY nginx/default.conf /etc/nginx/conf.d/default.conf
COPY public /var/www/html/public

