(function () {

  function AppController($http) {



    this.data = []

    this.loadData =  () => {
      $http.get('/resources/load?resource=orders').then((response) => {
        this.data = response.data.data
      })
    }

    //http://localhost:8000/resources/append-resource?part=customer&fileName=/Users/martodox/School/xml/uploads/test.xml&resource=orders

    this.onFileSend = (content) => {

      $http.get('/resources/validate-resource?part=' + content.data.resourcePart + '&fileName=' + content.data.fileName).then((isValid) => {
        console.log(isValid)
      })


    }


    return this

  }


  angular.module('sampleXml', [
    'ngUpload'
  ])
    .controller('AppController', ['$http', AppController])


}())