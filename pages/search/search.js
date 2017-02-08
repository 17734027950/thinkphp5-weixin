const app = getApp()
Page({
    data: {
        movies: []
    },
    search (e) {
        console.log(e.detail.value)
        app.fetch('search', e.detail.value)
            .then( res => {
                this.setData({movies:res.data.subjects})
                console.log(res)
            })
    }
})