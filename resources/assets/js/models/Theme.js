class Theme {
    static fetchAll(then) {
        return axios.get('/themes')
            .then(response => then(response.data));
    }
}

export default Theme;
