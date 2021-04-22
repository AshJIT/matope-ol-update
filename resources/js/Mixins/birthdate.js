export default {
    methods: {
        displayBirthdate(dob) {
            var options = { year: 'numeric', month: 'long', day: 'numeric' };
            var birthdate  = new Date(dob);

            return birthdate.toLocaleDateString("en-US", options);
        }
    }
  };