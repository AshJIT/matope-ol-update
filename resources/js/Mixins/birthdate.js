export default {
    methods: {
        displayBirthdate(dob) {
            const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            let date = dob.split("-");

            return months[parseInt(date[1] - 1)] + " " + date[2] + ", " + date[0];
        }
    }
  };