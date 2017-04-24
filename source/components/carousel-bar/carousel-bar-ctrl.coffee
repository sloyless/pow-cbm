app.controller 'carouselBarCtrl', ($scope, $sce, apiService) ->
  $scope.loading = true
  $scope.carouselComics = {}
  apiService.carouselComics()
  .then (result) ->
    carouselComics = result.data
    angular.forEach carouselComics, (key) ->
      if key.plot isnt ''
        key.plot = key.plot.split(" ").splice(0,30).join(" ") + ' [...]'
        key.plot = $sce.trustAsHtml(key.plot)
      false
    $scope.carouselComics = carouselComics
    $scope.loading = false
  .catch (reason) ->
    console.log reason
  $scope.active = 0