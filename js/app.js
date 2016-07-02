(function () {

  function AppController($http) {


    this.success = false
    this.error = false

    this.showMessages = false
    this.data = []

    this.validationErrors = []

    function normalize(response) {

      if (angular.isDefined(response.Customers.Customer) && !Array.isArray(response.Customers.Customer)) {
        response.Customers.Customer = [response.Customers.Customer]
      }

      if (angular.isDefined(response.Orders.Order) && !Array.isArray(response.Orders.Order)) {
        response.Orders.Order = [response.Orders.Order]
      }

      return response;
    }

    this.loadData =  () => {
      $http.get('/resources/load?resource=orders').then((response) => {
        this.data = normalize(response);
      })
    }

    this.removeData = () => {
      $http.get('/resources/remove-resource?resource=orders').then(() => {
        this.loadData()
      })
    }

    this.onFileSend = (content) => {

      $http.get('/resources/validate-resource?fileName=' + content.data.fileName + '&part=' + content.data.resourcePart).then((response) => {
        if (response.valid) {
          $http.get('/resources/append-resource?resource=orders&fileName=' + content.data.fileName +'&part=' + content.data.resourcePart).then(() => {
            this.showMessages = true
            this.success = true
            this.error = false
          })
        } else {
          this.showMessages = true
          this.success = false
          this.error = true
          this.validationErrors = response.errors
        }
      })


    }


    return this

  }


  angular.module('sampleXml', [
    'ngUpload'
  ])
    .config(['$httpProvider', ($httpProvider) => {
      $httpProvider.interceptors.push(() => {
        return {
          'response': (response) => {
            return response.data.data
          }
        };
      });
    }])
    .controller('AppController', ['$http', AppController])


}())