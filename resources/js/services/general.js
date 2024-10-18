export default {
    getColorChipStatus(value) {
        if (value) {
            if (value.toLowerCase() === 'pending') {
                return 'orange'
            } else {
                return 'green'
            }
        } else return ""
    },
    getColorChipRole(value) {
        if (value) {
            if (value.toLowerCase() === 'user') {
                return 'orange'
            } else {
                return 'green'
            }
        } else return ""
    }
}