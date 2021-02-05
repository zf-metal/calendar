
import HttpRequest from './../HttpRequest'

class CategoryProvider extends HttpRequest {

    findAll(){
        return this.fetchAll()
    }
}

export default CategoryProvider
