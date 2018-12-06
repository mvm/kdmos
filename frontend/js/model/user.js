class UserModel extends Fronty.Model {
  constructor(id, name, surname, email, pass) {
    super('UserModel');
	
	
    this.isLogged = false;
  }

  setLoggeduser(loggedUser) {
    this.set((self) => {
      self.currentUser = loggedUser;
	/*  Object.assign(self, loggedUser);
	  alert(JSON.stringify(self));*/
      self.isLogged = true;
    });
  }

  logout() {
    this.set((self) => {
      delete self.currentUser;
      self.isLogged = false;
    });
  }
}
