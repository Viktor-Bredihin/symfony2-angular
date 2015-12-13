'use strict';

angular.module('post', ['ngResource'])
    // rest factory
    .factory('Posts', function ($resource) {
        return $resource(
            Routing.generate('posts', {}, true) + ':id', {id: '@id'}
        );
    })
    .controller('post', function($scope, Posts) {
        // predefined data
        $scope.errors = [];
        $scope.postFilters = [
            { id: 'all',     name: 'All' },
            { id: 'random',  name: 'Random' },
            { id: 'lminute', name: 'Last Minute' }
        ];
        $scope.activePostFilter = $scope.postFilters[0];

        $scope.canSave = function() {
            return $scope.postForm.$dirty && $scope.postForm.$valid;
        }

        $scope.createPost = function(post) {
            Posts.save({}, {'post': post})
                .$promise.then(
                    // success
                    function(post) {
                        $scope.posts.push(post);
                    },
                    // error handler
                    function(errors) {
                        $scope.errors = [];
                        angular.forEach(errors.data.errors.children, function(field, name) {
                            if (typeof field.errors != 'undefined' && field.errors.length) {
                                for (var i = 0; i < field.errors.length; i++) {
                                    $scope.errors.push(name + ': ' + field.errors[i]);
                                }
                            }
                        });
                    }
                )
        }

        $scope.editPost = function(post) {
            Posts.save({id: post.id}, {'post': {'title': post.title, 'description': post.description}})
                .$promise.then(
                    // success
                    function(post) {
                        $scope.posts[$scope.posts.indexOf(post)] = post;
                    },
                    // error handler
                    function(errors) {
                        $scope.errors = [];
                        angular.forEach(errors.data.errors.children, function(field, name) {
                            if (typeof field.errors != 'undefined' && field.errors.length) {
                                for (var i = 0; i < field.errors.length; i++) {
                                    $scope.errors.push(name + ': ' + field.errors[i]);
                                }
                            }
                        });
                    }
                )
        }

        $scope.deletePost = function(post) {
            Posts.delete({id: post.id})
                .$promise.then(function() {
                    $scope.posts.splice($scope.posts.indexOf(post), 1);
                });
        }

        $scope.getPosts = function(filter) {
            var params = {};
            if (!filter) {
                filter = $scope.activePostFilter;
            }
            switch (filter.id) {
                case 'random':
                    params.random = true;
                    break;
                case 'lminute':
                    params.last_minutes = 1;
                    break;
                case 'all':
                    params.order_by = 'created';
                    break;
            }
            $scope.activePostFilter = filter;
            $scope.posts = Posts.query(params);
        }

        $scope.getPosts();
    });
