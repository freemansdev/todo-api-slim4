.PHONY: clean migrate

up:
	docker-compose up
	@echo "INFO: waiting for mariadb initialization"

down:
	docker-compose down

migrate:
	docker-compose exec slim sh -c "./vendor/bin/phinx migrate"

test:
	docker-compose exec -e MYSQL_DATABASE=todo_test -e PHINX_DB_DATABASE=todo_test slim sh -c "./vendor/bin/phinx rollback -t 0"
	docker-compose exec -e MYSQL_DATABASE=todo_test -e PHINX_DB_DATABASE=todo_test slim sh -c "./vendor/bin/phinx migrate"
	docker-compose exec -e MYSQL_DATABASE=todo_test -e PHINX_DB_DATABASE=todo_test slim sh -c "./vendor/bin/phpunit"

reset-test:
	docker-compose exec -e MYSQL_DATABASE=todo_test -e PHINX_DB_DATABASE=todo_test slim sh -c "./vendor/bin/phinx rollback -t 0"

reset-all:
	docker-compose exec slim sh -c "./vendor/bin/phinx rollback -t 0"
	docker-compose exec -e MYSQL_DATABASE=todo_test -e PHINX_DB_DATABASE=todo_test slim sh -c "./vendor/bin/phinx rollback -t 0"
	docker-compose exec slim sh -c "./vendor/bin/phinx migrate"

clean: reset-all