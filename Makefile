.DEFAULT_GOAL = help
DOCKER_COMPOSE=@docker compose
DOCKER_EXEC=@docker exec -it
# Get APP_NAME from .env file
APP_NAME=$(shell grep APP_NAME ./deployments/local/.env | cut -d= -f2)

help:
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^## ——)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help

## —— Docker 🐳  —————————————————————————————————————————————————————
start:	## Lancer les containers docker (en mode dev)
	$(DOCKER_COMPOSE) -f ./deployments/local/compose.yaml up -d
.PHONY: start

stop:	## Arréter les containers docker
	$(DOCKER_COMPOSE) -f ./deployments/local/compose.yaml down
.PHONY: stop

restart: stop start	## redémarrer les containers (en mode dev)
.PHONY: restart

ps: ## Affiche les containers docker
	@docker ps
.PHONY: ps

bash: ## Entrer dans le container PHP
	$(DOCKER_EXEC) $(APP_NAME)_app bash
.PHONY: bash

bash-front: ## Entrer dans le container Node.js
	$(DOCKER_EXEC) $(APP_NAME)_front bash
.PHONY: bash-front

bash-db: ## Entrer dans le container de la base de données
	$(DOCKER_EXEC) $(APP_NAME)_db bash
.PHONY: bash-db
