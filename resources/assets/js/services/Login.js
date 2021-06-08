import axios from 'axios'

const baseUrl = '/goals/'

export default class Login {
    // static retrieve (type, payload = {}, callback) {
    //     axios.get(baseUrl+type, payload).then(callback)
    // }
    //
    // static store (payload, callback) {
    //     console.log(callback)
    //
    //     axios.post(baseUrl, payload).then(callback)
    // }
    //
    // static edit (payload, callback) {
    //     console.log(callback)
    //
    //     axios.post(baseUrl+'edit', payload).then(callback)
    // }
    //
    // static delete (payload, callback) {
    //     console.log(callback)
    //
    //     axios.post(baseUrl+'delete', payload).then(callback)
    // }
    //
    // static check (payload, callback) {
    //     console.log(callback)
    //
    //     axios.post(baseUrl+'check', payload).then(callback)
    // }

    static register (payload, callback) {
        console.log(callback);

        axios.post('/get-login-route').then(callback)
    }
}
