var name_default = document.getElementById('name').value;
var position_default = document.getElementById('position').value;

console.log(name_default, position_default);

new Vue({
    el: "#form",
    data:{
        errors: [],
        name: name_default,
        position: position_default,

    },
    methods:{
        checkForm: function(e){
            console.log(this.name, this.position);
            this.errors = [];

            if(this.name == ""){ 
                this.errors.push("Не добавлено имя");
            }
            if(this.position == ""){ 
                this.errors.push("Не добавлена позиция");
            }

            if(!this.errors.length){
                return true;
            }

            e.preventDefault();
        }
    },

})