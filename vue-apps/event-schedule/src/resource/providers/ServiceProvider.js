import HttpRequest from './../HttpRequest'

class ServiceProvider extends HttpRequest {
    createService(service) {
        return this.create('', service)
    }

    updateService(service) {
        return this.update(service.id, service)
    }


    serviceSearch(id, client, branchOffice, location) {
        let params = {id: id, client: client, branchOffice: branchOffice, location: location}
        return this.axios.post(
            '/zfmc/serviceSearch',
            params,
            {
                headers: {
                    'Content-Type': 'application/json'
                }
            }
        )
    }
}

export default ServiceProvider
