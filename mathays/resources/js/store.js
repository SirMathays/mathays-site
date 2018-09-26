var timeout;

export default {
    debug: process.env.NODE_ENV == 'development' ? true : false,
    state: {
        messages: []
    },
    setMessageAction(text = 'Tuntematon virhe', type = 'danger') {

        // Debug
        if (this.debug) console.log('setMessageAction triggered with', text, type)

        // New Message
        this.state.messages.push({
            text: text,
            type: type,
            key: Math.random().toString(36).substring(7)
        })
    },
    dropMessageItem(key) {
        var index = this.state.messages.findIndex(x => x.key == key)
        this.state.messages.splice(index, 1);
    }
}