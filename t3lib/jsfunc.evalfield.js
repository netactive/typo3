/***************************************************************
*
*  Evaluation of TYPO3 form field content
*
* $Id: jsfunc.evalfield.js 2754 2007-11-23 14:57:51Z ohader $
*
*
*
*  Copyright notice
*
*  (c) 1998-2007 Kasper Skaarhoj
*  All rights reserved
*
*  This script is part of the TYPO3 t3lib/ library provided by
*  Kasper Skaarhoj <kasper@typo3.com> together with TYPO3
*
*  Released under GNU/GPL (see license file in typo3/sysext/cms/tslib/)
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*
*  This copyright notice MUST APPEAR in all copies of this script
***************************************************************/


function evalFunc()	{
	this.input = evalFunc_input;
	this.output = evalFunc_output;
	this.parseInt = evalFunc_parseInt;
	this.getNumChars = evalFunc_getNumChars;
	this.parseDouble = evalFunc_parseDouble;
	this.noSpace = evalFunc_noSpace;
	this.getSecs = evalFunc_getSecs;
	this.getYear = evalFunc_getYear;
	this.getTimeSecs = evalFunc_getTimeSecs;
	this.caseSwitch = evalFunc_caseSwitch;
	this.evalObjValue = evalFunc_evalObjValue;
	this.outputObjValue = evalFunc_outputObjValue;
	this.split = evalFunc_splitStr;
	this.pol = evalFunc_pol;

	this.ltrim = evalFunc_ltrim;
	this.btrim = evalFunc_btrim;
	var today = new Date();
 	this.lastYear = this.getYear(today);
 	this.lastDate = this.getSecs(today);
 	this.lastTime = this.getTimeSecs(today);
	this.isInString = '';
	this.USmode = 0;
}
function evalFunc_pol(fortegn, value)	{
	return eval (((fortegn=="-")?'-':'')+value);
}
function evalFunc_evalObjValue(FObj,value)	{
	var evallist = FObj.evallist;
	this.isInString = (FObj.is_in) ? ''+FObj.is_in : '';
	var index=1;
	var theEvalType = (FObj.evallist) ? this.split(evallist, ",", index) : false;
	var newValue=value;
	while (theEvalType) {
		if (theEvalType.slice(0, 3) == 'tx_') {
			if(typeof window[theEvalType] == 'function') {
				newValue = window[theEvalType](newValue);	// variable function call, calling functions like tx_myext_myeval(value)
			}
		} else {
			newValue = evalFunc.input(theEvalType, newValue);
		}
		index++;
		theEvalType = this.split(evallist, ",", index);
	}
	return newValue;
}
function evalFunc_outputObjValue(FObj,value)	{
	var evallist = FObj.evallist;
	var index=1;
	var theEvalType = this.split(evallist, ",", index);
	var newValue=value;
	while (theEvalType) {
		if (theEvalType != 'required') {
			newValue = evalFunc.output(theEvalType, value, FObj);
		}
		index++;
		theEvalType = this.split(evallist, ",", index);
	}
	return newValue;
}
function evalFunc_caseSwitch(type,inVal)	{
	var theVal = ''+inVal;
	var newString = '';
	switch (type)	{
		case "alpha":
		case "num":
		case "alphanum":
		case "alphanum_x":
			for (var a=0;a<theVal.length;a++)	{
				var theChar = theVal.substr(a,1);
				var special = (theChar=='_'||theChar=='-');
				var alpha = (theChar>='a'&&theChar<='z') || (theChar>='A'&&theChar<='Z');
				var num = (theChar>='0' && theChar<='9');
				switch(type)	{
					case "alphanum":	special=0;		break;
					case "alpha":	num=0; special=0;		break;
					case "num":	alpha=0; special=0;		break;
				}
				if (alpha || num || theChar==' ' || special)	{
					newString+=theChar;
				}
			}
		break;
		case "is_in":
			if (this.isInString)	{
				for (var a=0;a<theVal.length;a++)	{
					var theChar = theVal.substr(a,1);
					if (this.isInString.indexOf(theChar)!=-1)	{
						newString+=theChar;
					}
				}
			} else {newString = theVal;}
		break;
		case "nospace":
			newString = this.noSpace(theVal);
		break;
		case "upper":
			newString = theVal.toUpperCase();
		break;
		case "lower":
			newString = theVal.toLowerCase();
		break;
		default:
			return inVal;
	}
	return newString;
}
function evalFunc_parseInt(value)	{
	var theVal = ''+value;
	if (!value)	return 0;
	for (var a=0;a<theVal.length;a++)	{
		if (theVal.substr(a,1)!='0')	{
			return parseInt(theVal.substr(a,theVal.length)) || 0;
		}
	}
	return 0;
}
function evalFunc_getNumChars(value)	{
	var theVal = ''+value;
	if (!value)	return 0;
	var outVal="";
	for (var a=0;a<theVal.length;a++)	{
		if (theVal.substr(a,1)==parseInt(theVal.substr(a,1)))	{
			outVal+=theVal.substr(a,1);
		}
	}
	return outVal;
}
function evalFunc_parseDouble(value)	{
	var theVal = ''+value;
	var dec=0;
	if (!value)	return 0;
	for (var a=theVal.length; a>0; a--)	{
		if (theVal.substr(a-1,1)=='.' || theVal.substr(a-1,1)==',')	{
			dec = theVal.substr(a);
			theVal = theVal.substr(0,a-1);
			break;
		}
	}
	dec = this.getNumChars(dec)+'00';
	theVal=this.parseInt(this.noSpace(theVal))+TS.decimalSign+dec.substr(0,2);

	return theVal;
}
function evalFunc_noSpace(value)	{
	var theVal = ''+value;
	var newString="";
	for (var a=0;a<theVal.length;a++)	{
		var theChar = theVal.substr(a,1);
		if (theChar!=' ')	{
			newString+=theChar;
		}
	}
	return newString;
}
function evalFunc_ltrim(value)	{
	var theVal = ''+value;
	if (!value)	return '';
	for (var a=0;a<theVal.length;a++)	{
		if (theVal.substr(a,1)!=' ')	{
			return theVal.substr(a,theVal.length);
		}
	}
	return '';
}
function evalFunc_btrim(value)	{
	var theVal = ''+value;
	if (!value)	return '';
	for (var a=theVal.length;a>0;a--)	{
		if (theVal.substr(a-1,1)!=' ')	{
			return theVal.substr(0,a);
		}
	}
	return '';
}
function evalFunc_splitSingle(value)	{
	var theVal = ''+value;
	this.values = new Array();
	this.pointer = 3;
	this.values[1]=theVal.substr(0,2);
	this.values[2]=theVal.substr(2,2);
	this.values[3]=theVal.substr(4,10);
}
function evalFunc_split(value)	{
	this.values = new Array();
	this.valPol = new Array();
	this.pointer = 0;
	var numberMode = 0;
	var theVal = "";
	value+=" ";
	for (var a=0;a<value.length;a++)	{
		var theChar = value.substr(a,1);
		if (theChar<"0" || theChar>"9")	{
			if (numberMode)	{
				this.pointer++;
				this.values[this.pointer]=theVal;
				theVal = "";
				numberMode=0;
			}
			if (theChar=="+" || theChar=="-")	{
				this.valPol[this.pointer+1] = theChar;
			}
		} else {
			theVal+=theChar;
			numberMode=1;
		}
	}
}
function evalFunc_input(type,inVal)	{
	if (type=="md5") {
		return MD5(inVal);
	}
	if (type=="trim") {
		return this.ltrim(this.btrim(inVal));
	}
	if (type=="int") {
		return this.parseInt(inVal);
	}
	if (type=="double2") {
		return this.parseDouble(inVal);
	}

	var today = new Date()
	var add=0;
	var value = this.ltrim(inVal);
	var values = new evalFunc_split(value);
	var theCmd = value.substr(0,1);
	value = this.caseSwitch(type,value);
	if (value=="") {
		return "";
		return 0;	// Why would I ever return a zero??? (20/12/01)
	}
	switch (type)	{
		case "datetime":
			switch (theCmd)	{
				case "d":
				case "t":
				case "n":
					var theTime = new Date(this.getYear(today), today.getMonth(), today.getDate(), today.getHours(), today.getMinutes());
					this.lastDate = this.getSecs(theTime)
					if (values.valPol[1])	{
						add = this.pol(values.valPol[1],this.parseInt(values.values[1]));
					}
				break;
				case "+":
				case "-":
					if (values.valPol[1])	{
						add = this.pol(values.valPol[1],this.parseInt(values.values[1]));
					}
				break;
				default:
					var index = value.indexOf(' ');
					if (index!=-1)	{
						var theSecs = this.input("date",value.substr(index,value.length)) + this.input("time",value.substr(0,index));
						this.lastDate = theSecs;
					}
			}
			this.lastDate+=add*24*60*60;
			return this.lastDate;
		break;
		case "year":
			switch (theCmd)	{
				case "d":
				case "t":
				case "n":
					var theTime = today;
					this.lastYear = this.getYear(theTime);
					if (values.valPol[1])	{
						add = this.pol(values.valPol[1],this.parseInt(values.values[1]));
					}
				break;
				case "+":
				case "-":
					if (values.valPol[1])	{
						add = this.pol(values.valPol[1],this.parseInt(values.values[1]));
					}
				break;
				default:
					if (values.valPol[2])	{
						add = this.pol(values.valPol[2],this.parseInt(values.values[2]));
					}
					var year = (values.values[1])?this.parseInt(values.values[1]):this.getYear(today);
						if (  (year>=0&&year<38) || (year>=70&&year<100) || (year>=1970&&year<2038)	)	{
							if (year<100)	{
								year = (year<38) ? year+=2000 : year+=1900;
							}
						} else {year = this.getYear(today);}
					this.lastYear = year
			}
			this.lastYear+=add;
			return this.lastYear;
		break;
		case "date":
			switch (theCmd)	{
				case "d":
				case "t":
				case "n":
					var theTime = new Date(this.getYear(today), today.getMonth(), today.getDate());
					this.lastDate = this.getSecs(theTime);
					if (values.valPol[1])	{
						add = this.pol(values.valPol[1],this.parseInt(values.values[1]));
					}
				break;
				case "+":
				case "-":
					if (values.valPol[1])	{
						add = this.pol(values.valPol[1],this.parseInt(values.values[1]));
					}
				break;
				default:
					var index = 4;
					if (values.valPol[index])	{
						add = this.pol(values.valPol[index],this.parseInt(values.values[index]));
					}
					if (values.values[1] && values.values[1].length>2)	{
						if (values.valPol[2])	{
							add = this.pol(values.valPol[2],this.parseInt(values.values[2]));
						}
						var temp = values.values[1];
						values = new evalFunc_splitSingle(temp);
					}

					var year = (values.values[3])?this.parseInt(values.values[3]):this.getYear(today);
						if (  (year>=0&&year<38) || (year>=70&&year<100) || (year>=1970&&year<2038)	)	{
							if (year<100)	{
								year = (year<38) ? year+=2000 : year+=1900;
							}
						} else {year = this.getYear(today);}
					var month = (values.values[this.USmode?1:2])?this.parseInt(values.values[this.USmode?1:2]):today.getMonth()+1;
						if (month > 12)	{month=12;}
						if (month < 1)	{month=1;}
					var day = (values.values[this.USmode?2:1])?this.parseInt(values.values[this.USmode?2:1]):today.getDate();
						if (day > 31)	{day=31;}
						if (day < 1)	{day=1;}
					if (''+day+'-'+month+'-'+year == "1-1-1970")	{
						var theTime = new Date();  theTime.setTime(0);
					} else {
						var theTime = new Date(parseInt(year), parseInt(month)-1, parseInt(day));
					}
					this.lastDate = this.getSecs(theTime)
			}
			this.lastDate+=add*24*60*60;
			if (this.lastDate<0) {this.lastDate=0;}
			return this.lastDate;
		break;
		case "time":
		case "timesec":
			switch (theCmd)	{
				case "d":
				case "t":
				case "n":
					var theTime = new Date(this.getYear(today), today.getMonth(), today.getDate(), today.getHours(), today.getMinutes(), ((type=="timesec")?today.getSeconds():0));
					this.lastTime = this.getTimeSecs(theTime);
					if (values.valPol[1])	{
						add = this.pol(values.valPol[1],this.parseInt(values.values[1]));
					}
				break;
				case "+":
				case "-":
					if (values.valPol[1])	{
						add = this.pol(values.valPol[1],this.parseInt(values.values[1]));
					}
				break;
				default:
					var index = (type=="timesec")?4:3;
					if (values.valPol[index])	{
						add = this.pol(values.valPol[index],this.parseInt(values.values[index]));
					}
					if (values.values[1] && values.values[1].length>2)	{
						if (values.valPol[2])	{
							add = this.pol(values.valPol[2],this.parseInt(values.values[2]));
						}
						var temp = values.values[1];
						values = new evalFunc_splitSingle(temp);
					}
					var sec = (values.values[3])?this.parseInt(values.values[3]):today.getSeconds();
						if (sec > 59)	{sec=59;}
					var min = (values.values[2])?this.parseInt(values.values[2]):today.getMinutes();
						if (min > 59)	{min=59;}
					var hour = (values.values[1])?this.parseInt(values.values[1]):today.getHours();
						if (hour > 23)	{hour=23;}
					var theTime = new Date(this.getYear(today), today.getMonth(), today.getDate(), hour, min, ((type=="timesec")?sec:0));
					this.lastTime = this.getTimeSecs(theTime)
			}
			this.lastTime+=add*60;
			if (this.lastTime<0) {this.lastTime+=24*60*60;}
			return this.lastTime;
		break;
		default:
			return value;
	}
}
function evalFunc_output(type,value,FObj)	{
	var theString = "";
	switch (type)	{
		case "date":
			if (!parseInt(value))	{return '';}
			var theTime = new Date();
			theTime.setTime(value*1000);
			if (this.USmode)	{
				theString = (theTime.getMonth()+1)+'-'+theTime.getDate()+'-'+this.getYear(theTime);
			} else {
				theString = theTime.getDate()+'-'+(theTime.getMonth()+1)+'-'+this.getYear(theTime);
			}
		break;
		case "datetime":
			if (!parseInt(value))	{return '';}
			var theTime = new Date();
			theTime.setTime(value*1000);
			theString = this.output("time",this.getTimeSecs(theTime))+' '+this.output("date",value);
		break;
		case "time":
		case "timesec":
			if (!parseInt(value))	{return '';}
			var theTime = new Date();
			theTime.setTime(value*1000);
			var h = Math.floor(value/3600);
			var m = Math.floor((value-h*3600)/60);
			var s = Math.floor(value-h*3600-m*60);
			theString = h+':'+((m<10)?'0':'')+m + ((type=="timesec")?':'+((s<10)?'0':'')+s:'');
		break;
		case "password":
			theString = (value)	? TS.passwordDummy : "";
		break;
		case "int":
			theString = (FObj.checkbox && value==FObj.checkboxValue)?'':value;
		break;
		default:
			theString = value;
	}
	return theString;
}
function evalFunc_getSecs(timeObj)	{
	return Math.round(timeObj.getTime()/1000);
}
function evalFunc_getYear(timeObj)	{
	return (timeObj.getYear()>200) ? timeObj.getYear() : (timeObj.getYear()+1900);
}
function evalFunc_getTimeSecs(timeObj)	{
	return timeObj.getHours()*60*60+timeObj.getMinutes()*60+timeObj.getSeconds();
}
function evalFunc_dummy (evallist,is_in,checkbox,checkboxValue) {
	this.evallist = evallist;
	this.is_in = is_in;
	this.checkboxValue = checkboxValue;
	this.checkbox = checkbox;
}
function evalFunc_splitStr(theStr1, delim, index) {
	var theStr = ''+theStr1;
	var lengthOfDelim = delim.length;
	sPos = -lengthOfDelim;
	if (index<1) {index=1;}
	for (a=1; a<index; a++)	{
		sPos = theStr.indexOf(delim, sPos+lengthOfDelim);
		if (sPos==-1)	{return null;}
	}
	ePos = theStr.indexOf(delim, sPos+lengthOfDelim);
	if(ePos == -1)	{ePos = theStr.length;}
	return (theStr.substring(sPos+lengthOfDelim,ePos));
}

