
import HttpRequest from './../HttpRequest'

class ServiceProvider extends HttpRequest {
    createService (service) {
        return this.create('', service)
    }

    updateService (service){
        return this.update(service.id, service)
    }


    serviceSearch(id,account,branchOffice,address){
        let params = {id: id,account: account,branchOffice: branchOffice,address:address}
        return this.request('POST','/zfmc/serviceSearch',params)
    }
}

export default ServiceProvider
