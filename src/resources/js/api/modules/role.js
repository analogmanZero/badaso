import resource from '../resource'
import endpoint from '../endpoint'
import QueryString from '../query-string'

export default {
    browse(data) {
        let ep = endpoint.role.browse
        let qs = QueryString(data)
        let url = ep + qs
        return resource.get(url)
    },

    read(data) {
        let ep = endpoint.role.read
        let qs = QueryString(data)
        let url = ep + qs
        return resource.get(url)
    },

    edit(data) {
        return resource.put(endpoint.role.edit, data)
    },

    add(data) {
        return resource.post(endpoint.role.add, data)
    },

    delete(data) {
        return resource.delete(endpoint.role.delete, data)
    },

    setPermission(data) {
        return resource.post(endpoint.role.setPermission, data)
    },
}