const app = getApp()
import Promise from '../../utils/promise.js'
Page({
    data: {
        boards: [
            {key: 'top250'},
            {key: 'in_theaters'},
            {key: 'coming_soon'},
            {key: 'top250'}
        ]
    },
    onLoad () {
        let movies = this.data.boards.map( board => {
            return app.fetch(board.key, {count:10})
                .then(d => {
                    board.title = d.data.title;
                    board.movies = d.data.subjects;
                    return board;
                })
        });
        Promise.all(movies).then( movies => {
            this.setData({boards:movies})
        })
    }
})