import resource from '../resource'
import endpoint from '../endpoint'
import QueryString from '../query-string'

export default {
    browse(data) {
        let ep = endpoint.configuration.browse
        let qs = QueryString(data)
        let url = ep + qs
        return resource.get(url)
    },

    read(data) {
        let ep = endpoint.configuration.read
        let qs = QueryString(data)
        let url = ep + qs
        return resource.get(url)
    },

    edit(data) {
        return resource.put(endpoint.configuration.edit, data)
    },

    editMultiple(data) {
        return resource.put(endpoint.configuration.editMultiple, data)
    },

    add(data) {
        return resource.post(endpoint.configuration.add, data)
    },

    delete(data) {
        return resource.delete(endpoint.configuration.delete, data)
    },

}