# CONTRIBUTING

## Recommended workflow

### Step 1: Make your own fork.

1. Setup a [GitHub account](https://github.com/), if you haven't yet.
2. Fork the project (i.e from the github project page). 
3. Clone your newly created fork: 

```shell
$ git clone https://github.com/<username>/soluble-jasper.git`
```

4. Install deps

```shell
$ composer update
```

### Step 2: Prepare your test env. 

Setup a local JasperBridgeServer and copy `./phpunit.xml.dist` in
`./phpunit.xml` (edit config as needed). 

Check phpunit works by running 

```shell
$ ./vendor/bin/phpunit
```

### Step 3: Change code  

1. Create a new branch from master (i.e. feature/24)
2. Modify the code... Fix, improve :)

### Step 4: Release a P/R (pull request)

1. First ensure the code is clean

```shell
$ composer fix
$ composer check
```
2. Commit/Push your pull request. 


## Notes

### Mkdocs

If you're working on documentation, please install mkdocs:

```shell
$ pip install mkdocs mkdocs-material pygments pymdown-extensions --upgrade 
```

You can serve the doc:

```shell
$ mkdocs serve --dev-addr localhost:8081
```

   

