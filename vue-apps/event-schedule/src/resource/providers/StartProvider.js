
import HttpRequest from './../HttpRequest'

class StartProvider extends HttpRequest {
    start () {
        return this.request('GET', process.env.VUE_APP_BASE_API_URL+'start')
    }

}

export default StartProvider