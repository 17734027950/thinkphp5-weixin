const app = getApp()
Page({
    data: {
        movies: [],
        keywords: '',
        page: 1,
        loading: false
    },
    search (e) {
        if (!e.detail.value) return
        this.setData({
            movies: [],
            keywords: e.detail.value,
            loading: true
        })
        app.fetch('search', {q:e.detail.value,count: 10})
            .then( res => {
                this.setData({
                    movies: res.data.subjects,
                    loading: false
                })
            })
    },
    loadMore () {
        this.setData({loading: true})
        let params = {
            q: this.data.keywords,
            count: 10,
            start: (this.data.page++)*10
        }
        app.fetch('search', params)
            .then( res => {
                this.setData({
                    movies: this.data.movies.concat(res.data.subjects),
                    loading: false
                })
            })
    }
})