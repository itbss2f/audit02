
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>AngularJS ui-validate</title>
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css"/>
    </head>

    <body class="container">
        <section id="validate" ng-controller="user">
            <div class="page-header">
                <h1>Validate</h1>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="well">
                        <form name="form">
                            <h3>e-mail</h3>
                            <input class="form-control" name="email" placeholder="try john.doe@mail.com or bad@domain.com" type="email" required ng-model="email" ng-model-options="{ debounce: 100 }"
                            ui-validate="{blacklist: 'notBlackListed($value)'}"
                            ui-validate-async="{alreadyExists: 'doesNotExist($modelValue)'}">
                            <span ng-show='form.email.$error.blacklist'>This e-mail is black-listed!</span>
                            <span ng-show='form.email.$error.alreadyExists'>This e-mail is already taken!</span>
                            <span ng-show='form.email.$pending'>Verifying e-mail on server...</span>
                            
                            <br>is form valid: {{form.$valid}}
                            <br>
                            <br>email errors: {{form.email.$error | json}}
                            <br>email pending: {{form.email.$pending | json}}
                            <h3>password</h3>
                            <input class="form-control" name="password" type="text" required ng-model="password" placeholder="password">
                            <input class="form-control" name="confirm_password" type="text" required ng-model="confirm_password" ui-validate=" '$value==password' "
                            ui-validate-watch=" 'password' " placeholder="confirm password">
                            <span ng-show='form.confirm_password.$error.validator'>Passwords do not match!</span>
                            <br>is form valid: {{form.$valid}}
                            <br>
                            <br>password errors: {{form.confirm_password.$error| json}}</form>
                    </div>
                    
                </div>
                <div class="col-md-6">
                </div>
            </div>
        </section>
    </body>

</html>

 <script type="text/javascript" src="angular.min.js">
 
    var app = angular.module('assets', ['ui.validate-master']);
    app.controller('user', function($scope, $timeout, $q) {
        $scope.notBlackListed = function(value) {
            var blacklist = ['bad@domain.com', 'verybad@domain.com'];
            return blacklist.indexOf(value) === -1;
        };
        $scope.doesNotExist = function(value) {
            var db = ['john.doe@mail.com', 'jane.doe@mail.com'];
            // Simulates an asyncronous trip to the server.
            return $q(function(resolve, reject) {
                    $timeout(function() {
                    if (db.indexOf(value) < 0) {
                        resolve();
                    } else {
                        reject();
                    }
                }, 500);
            });
        };
    });
</script>  
