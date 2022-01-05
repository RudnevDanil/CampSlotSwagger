export let defaultStartSettings = [
    //  general
    {
        name: "general/getApiUrl",
        data: {}
    },

    //  user
    {
        name: "user/userCreate",
        data: {
            userName: "user123",
            login: "login123",
            pass: "pass123",
            avatar: "qweqwe", // ~
        }
    },
    {
        name: "user/userUpdate",
        data: {
            login: "login123",
            pass: "pass123",
            avatar: "qweqwe", // ~
        }
    },
    {
        name: "user/userDelete",
        data: {
            login: "login123",
            pass: "pass123",
        }
    },
    {
        name: "user/userAuth",
        data: {
            login: "login123",
            pass: "pass123",
        }
    },

    //  post
    {
        name: "post/createPost",
        data: {
            login: "login123",
            pass: "pass123",
            lat: "43.32",
            lon: "43.65",
            title: "title",
            transportRating: "55",
            rating: "4.4",
            text: "texttexttexttexttext", // ~
            imgs: JSON.stringify(["qweqwe", "qweqweqwe"]), // ~
            infrastructureArr: JSON.stringify(["water", "shower"]),
            isPaid: "true", // tf
            paymentText: "paymentText", // ~
        }
    },
    {
        name: "post/postUpdate",
        data: {
            login: "login123",
            pass: "pass123",
            title: "title2",
            transportRating: "66",
            rating: "3.4", // ~
            text: "texttexttexttexttext2", // ~
            imgs: JSON.stringify(["qweqwe11", "qweqweqwe22"]), // ~
            infrastructureArr: JSON.stringify(["water"/*, "shower"*/]),
            isPaid: "false", // tf
            paymentText: "paymentText2", // ~
        }
    },
    {
        name: "post/postDelete",
        data: {
            login: "login123",
            pass: "pass123",
            postId: "7",
        }
    },
    {
        name: "post/postGet",
        data: {
            postId: "7",
        }
    },
    {
        name: "post/postGetOfflinePosts",
        data: {
            login: "login123",
            pass: "pass123",
            postId: JSON.stringify(["3", "4", "5"]),
        }
    },
    {
        name: "post/postGetAnnounce",
        data: {
            postId: "7",
        }
    },
    {
        name: "post/getAllPostIds",
        data: {
            userId: "4",
        }
    },
    {
        name: "post/getAllIds",
        data: {
            login: "login123",
            pass: "pass123",
            lat: "43.32", // ~
            lon: "43.65", // ~
            radius: "1000", // ~
        }
    },
    {
        name: "map/getMap",
        data: {
            lat: "43.32",
            lon: "43.65",
            radius: "1000",
        }
    },

    //  mark
    {
        name: "mark/mark",
        data: {
            login: "login123",
            pass: "pass123",
            postId: "4",
            markState: "true", // tf
        }
    },
    {
        name: "mark/markList",
        data: {
            userId: "7",
            limit: "5", // ~
            offset: "0", // ~
        }
    },

    //  comment
    {
        name: "comment/commentCreate",
        data: {
            login: "login123",
            pass: "pass123",
            rating: "3.4",
        }
    },
    {
        name: "comment/commentUpdate",
        data: {
            login: "login123",
            pass: "pass123",
            commentId: "4",
            rating: "5", // ~
            text: "textcomment", // ~
            imgs: JSON.stringify(["qweqwe11", "qweqweqwe22"]), // ~
        }
    },
    {
        name: "comment/commentDelete",
        data: {
            login: "login123",
            pass: "pass123",
            commentId: "4",
        }
    },
    {
        name: "comment/commentGet",
        data: {
            postId: "4",
            limit: "5", // ~
            offset: "0", // ~
        }
    },

    //img
    {
        name: "img/getPostImgs",
        data: {
            postId: "4",
            limit: "5", // ~
            offset: "0", // ~
        }
    },
    {
        name: "img/getCommentImgs",
        data: {
            commentId: "4",
            limit: "5", // ~
            offset: "0", // ~
        }
    },

]