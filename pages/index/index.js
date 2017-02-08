//index.js
//获取应用实例
const app = getApp()
Page({
  data: {
    movie: []
  },
  onLoad () {
    app.fetch('coming_soon', {count:3})
      .then( d => {
        this.setData({movie: d.data.subjects})
      }
    )
  },
  EventHandle: function(){
    wx.switchTab({
      url: '../board/board'
    })
  }
})
