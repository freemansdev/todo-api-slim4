# Todo API (Slim Framework 4)

Simple todo API

## Required

* Docker
* docker-compose

## Run the Application

```bash
> make up
> make migrate
```
After that, API is available at `http://localhost:8080`

Run this command in the application directory to run the test suite, make sure Application is running

```bash
> make test
```

## API

> Please see the Application routes app/routes.php

### Projects
Get all projects
```bash
> http http://localhost:8080/projects
```

Create a project
```bash
> http -f POST http://localhost:8080/projects name=test
```

Edit the project
```bash
> http -f PUT http://localhost:8080/projects/1 name=test1
```

Remove the project
```bash
> http DELETE http://localhost:8080/projects/1
```

### Tasks
Get all tasks
```bash
> http http://localhost:8080/tasks
```

Create a task
```bash
> http -f POST http://localhost:8080/tasks name=test description=test-task project=1 'tag[]'=tag1 'tag[]'=tag2
```

Edit the task
```bash
> http -f PUT http://localhost:8080/tasks/1 name=test1
```

Remove the task
```bash
> http DELETE http://localhost:8080/tasks/1
```


> The **[http](https://httpie.org/)** tool

That's it!
