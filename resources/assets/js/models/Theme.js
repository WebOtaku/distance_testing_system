class Theme {
    static fetchAll(then) {
        return axios.get('/themes')
            .then(response => then(response.data));
    };

    static fetchPag(pInfo, then) {
        return axios.get('/themes', {
            params: {
                pageNumber: pInfo.pageNumber,
                pageSize: pInfo.pageSize
            }
        }).then(response => then(response.data));
    };

    static store(data, then) {
        return axios.post('/themes', data)
            .then(response => then(response.data));
    };

    static destroy(themeId) {
        return axios.delete(`/themes/${themeId}`);
    };
}

export default Theme;
