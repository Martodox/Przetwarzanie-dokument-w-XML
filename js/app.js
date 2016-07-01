(function () {

  function AppController($http) {



    this.data = []


    console.log(this.data)

    this.loadData =  () => {
      $http.get('/resources/load?resource=orders').then((response) => {
        this.data = response
      })
    }

    return this

  }


  angular.module('sampleXml', [])
    .controller('AppController', ['$http', AppController])


}())