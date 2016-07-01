(function () {

  function AppController($http) {



    this.data = []

    this.loadData =  () => {
      $http.get('/resources/load?resource=orders').then((response) => {
        this.data = response.data.data
      })
    }

    this.onFileSend = (content) => {
      console.log(content)
    }

    return this

  }


  angular.module('sampleXml', [
    'ngUpload'
  ])
    .controller('AppController', ['$http', AppController])


}())