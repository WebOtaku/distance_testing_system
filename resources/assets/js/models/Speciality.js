class Speciality {
    static fetchAll(then) {
        return axios.get('/specialities')
            .then(response => then(response.data));
    }
}

export default Speciality;
