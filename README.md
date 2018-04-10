Hi Berlin, would you like for some JAM party ? 

 ## How to start ##
- Install the dependencies with composer ```php composer.phar install```
- Start the build-in webserver ```php bin/console server:start```
- Verify the REST api is working ```http://localhost:8000/users```
- Verify the REST api is working ```http://localhost:8000/invites```

### Step 1 ###
- Let's run the fixtures! ```php bin/console hautelook:fixtures:load```
- Let's run the tests! ```php bin/phpspec run```

### Step 2 ###
- See the users list by link then submit invite```http://localhost:8000/users/list.html```
- See the invites list by link then apply invite```http://localhost:8000/invites/list.html```

Everyone likes clean code!

I prefer the PSR-1/2 and Symfony standards.

### Step N ###
See requirements: ```php bin/symfony_requirements```
 

