import HttpRequest from './../HttpRequest'

class ServiceProvider extends HttpRequest {
    createService(service) {
        return this.create('', service)
    }

    updateService(service) {
        return this.update(service.id, service)
    }


    serviceSearch(id, account, branchOffice, address) {
        let params = Querystring.stringify({id: id, account: account, branchOffice: branchOffice, address: address})
        return this.axios.post(
            '/zfmc/serviceSearch',
            params,
            {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }
        )
    }
}

export default ServiceProvider
