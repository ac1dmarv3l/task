# Use an official lightweight Alpine-based Postgres image as the base
FROM postgres:17-alpine

# Set a directory for custom scripts and configuration
WORKDIR /docker-entrypoint-initdb.d

# Install any additional utilities or dependencies (e.g., useful for debugging or extensions)
RUN apk add --no-cache bash curl jq musl-locales

# Expose the default Postgres port
EXPOSE 5432

# Set health check for the container to ensure PostgreSQL is running
HEALTHCHECK --interval=30s --timeout=10s --start-period=10s --retries=3 \
  CMD pg_isready -U $POSTGRES_USER -d $POSTGRES_DB || exit 1

# Entrypoint will remain the same as the base image
ENTRYPOINT ["docker-entrypoint.sh"]

# Default command to run when the container starts
CMD ["postgres"]
