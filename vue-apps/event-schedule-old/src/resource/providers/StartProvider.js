
import HttpRequest from './../HttpRequest'

class StartProvider extends HttpRequest {
    start () {
        return this.request('GET', '/zfmc/api/start')
    }

}

export default StartProvider