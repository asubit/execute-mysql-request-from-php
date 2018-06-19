# Execute SQL request from PHP
Useful script for execute SQL request and execute them online from PHP.

## Installation

### Download

#### With Git
`git clone https://github.com/asubit/execute-mysql-request-from-php.git`

#### With Github archive
```
wget https://github.com/asubit/execute-mysql-request-from-php/archive/master.zip
unzip master.zip
```

## Web view script

### Configure 

`vi script.php`

Write your specific configuration parameters for :
  - SQL Host
  - Database name
  - Database user
  - Database user's password

### Use

1. Acces the file from : http://www.your-domain.com/script.php
2. Write SQL request in the form
3. Click "Execute"
4. The results are displayed in a table under the form

## CLI script

### Configure 

`vi script-cli.php`

Write your specific configuration parameters for :
  - Translation
  - SQL Host
  - Database name
  - Database user
  - Database user's password
  
### Use

 1. From shell promt execute following : `php script-cli.php`
 2. The results are displayed in prompt
