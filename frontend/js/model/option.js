class OptionModel extends Fronty.Model {
    constructor(id, day, start, end) {
	super('OptionModel');

	if(id)
	    this.id = id;
	if(day)
	    this.day = day;
	if(start)
	    this.start = start;
	if(end)
	    this.end = end;
    }

    setId(id) {
	this.set((self) => {
	    self.id = id;
	});
    }

    setDay(day) {
	this.set((self) => {
	    self.day = day;
	});
    }
    
    setStart(start) {
	this.set((self) => {
	    self.start = start;
	});
    }
    
    setEnd(end) {
	this.set((self) => {
	    self.end = end;
	});
    }
}
