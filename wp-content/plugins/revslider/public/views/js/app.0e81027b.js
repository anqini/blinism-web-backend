(function(t){function e(e){for(var s,n,l=e[0],c=e[1],d=e[2],u=0,v=[];u<l.length;u++)n=l[u],Object.prototype.hasOwnProperty.call(r,n)&&r[n]&&v.push(r[n][0]),r[n]=0;for(s in c)Object.prototype.hasOwnProperty.call(c,s)&&(t[s]=c[s]);o&&o(e);while(v.length)v.shift()();return i.push.apply(i,d||[]),a()}function a(){for(var t,e=0;e<i.length;e++){for(var a=i[e],s=!0,l=1;l<a.length;l++){var c=a[l];0!==r[c]&&(s=!1)}s&&(i.splice(e--,1),t=n(n.s=a[0]))}return t}var s={},r={app:0},i=[];function n(e){if(s[e])return s[e].exports;var a=s[e]={i:e,l:!1,exports:{}};return t[e].call(a.exports,a,a.exports,n),a.l=!0,a.exports}n.m=t,n.c=s,n.d=function(t,e,a){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:a})},n.r=function(t){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"===typeof t&&t&&t.__esModule)return t;var a=Object.create(null);if(n.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var s in t)n.d(a,s,function(e){return t[e]}.bind(null,s));return a},n.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="/";var l=window["webpackJsonp"]=window["webpackJsonp"]||[],c=l.push.bind(l);l.push=e,l=l.slice();for(var d=0;d<l.length;d++)e(l[d]);var o=c;i.push([0,"chunk-vendors"]),a()})({0:function(t,e,a){t.exports=a("56d7")},"034f":function(t,e,a){"use strict";var s=a("85ec"),r=a.n(s);r.a},"077e":function(t,e,a){"use strict";var s=a("8bde"),r=a.n(s);r.a},1024:function(t,e,a){"use strict";var s=a("dfcc"),r=a.n(s);r.a},1379:function(t,e,a){},1520:function(t,e,a){t.exports=a.p+"img/calculator.dc1b3595.png"},"489f":function(t,e,a){t.exports=a.p+"img/gpa_logo.2851978f.png"},"55be":function(t,e,a){"use strict";var s=a("1379"),r=a.n(s);r.a},"56d7":function(t,e,a){"use strict";a.r(e);a("e260"),a("e6cf"),a("cca6"),a("a79d");var s=a("2b0e"),r=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"wrapper"},[a("mainBlock")],1)},i=[],n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"testbg"},[s("div",{staticClass:"classEditer"},[s("img",{staticClass:"logo",attrs:{src:a("489f"),alt:"logo",width:"400"}}),s("div",{attrs:{id:"circle"}}),s("img",{staticClass:"calculator",attrs:{src:a("1520"),alt:"calculator",width:"100"}}),t._m(0),s("addCourseTable",{attrs:{courses:t.courses}})],1),s("div",{staticClass:"summary"},[s("resultDisplay",{attrs:{courses:t.courses}})],1)])},l=[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"description"},[a("p",[t._v(" GPA是Grade Point Average的缩写，顾名思义就是平均分。AO习惯于把GPA看作衡量学生学习能力的参照数据，所以这个平时成绩是非常重要的。美国的GPA满分是4分，一般90以上是4.0，89-89是3.0，70-79是2.0，60-69是1.0，不及格就是0.0了。还有一种常见的算法，比刚才提到的标准算法要更精细一点，大概每3-5分是0.3-0.4的跨度。这两种算法下面有详细的对照表。 ")]),a("p",[t._v(" 国内用到的评分系统多种多样，百分制、4.0制、5.0制、XX学校制等等。度量衡未统一的话，我们很难去参考美国学校给出的招生标准，以及往年的录取数据。因此，我们需要把国内的成绩进行换算。既方便我们自己去客观评估自己的GPA，也方便在网申中填写一个靠谱的分数。 ")]),a("p",[t._v(" 还有一种情况，在不同的国家，或者多个学校修读过大学学分，那也需要自己计算一下，这样心里更有谱。因为学校一般可以计算外来的学分toward degree，但是不会把外校的GPA计算在内。 ")]),a("p",[t._v(" 为了给同学们节省时间，比邻主义特意做了这个线上GPA工具。希望有钱的可以捧个钱场，没钱的借钱捧个钱场。哈哈，开玩笑。辛苦你们把这个链接分享给更多有需要的同学们。 ")])])}],c=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{attrs:{id:"addCourseTable"}},[a("table",[t._m(0),t._l(t.courses,(function(e,s){return a("tr",{key:s},[a("td",[t._v(t._s(e.name))]),a("td",[t._v(t._s(e.credits))]),a("td",[t._v(t._s(e.letterGrade))]),a("td",[t._v(t._s(e.percentage))]),a("td",[t._v(t._s(e.gradepts))]),a("td",{staticStyle:{"background-color":"white"}},[a("div",{staticClass:"close small-x",on:{click:function(e){return t.deleteCourse(s)}}})])])}))],2),a("input",{directives:[{name:"model",rawName:"v-model",value:t.courseNumber,expression:"courseNumber"}],attrs:{type:"text"},domProps:{value:t.courseNumber},on:{input:function(e){e.target.composing||(t.courseNumber=e.target.value)}}}),a("button",{on:{click:t.addCourses}},[t._v("添加课程")])])},d=[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("tr",[a("th",{staticStyle:{width:"220px"}},[t._v("课程")]),a("th",{staticStyle:{width:"70px"}},[t._v("学分")]),a("th",{staticStyle:{width:"70px"}},[t._v("成绩"),a("br"),t._v("(A-F)")]),a("th",{staticStyle:{width:"70px"}},[t._v("成绩"),a("br"),t._v("(0-100)")]),a("th",{staticStyle:{width:"70px"}},[t._v("绩点"),a("br"),t._v("(0.0-4.0)")])])}],o=(a("a434"),{props:{courses:Array},data:function(){return{courseNumber:1}},created:function(){},methods:{deleteCourse:function(t){this.courses.splice(t,1),0==this.courses.length&&this.courses.push({name:"",credits:0,letterGrade:"",percentage:0,gradepts:0})},addCourses:function(){for(var t=0;t<this.courseNumber;t++)this.courses.push({name:"",credits:0,letterGrade:"",percentage:0,gradepts:0})}}}),u=o,v=(a("1024"),a("2877")),g=Object(v["a"])(u,c,d,!1,null,null,null),p=g.exports,h=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticStyle:{padding:"15px"},attrs:{id:"result"}},[t._m(0),t._m(1),a("button",{staticClass:"calGPA"},[t._v("Calculate GPA")]),a("h3",[t._v("Your GPA")]),a("div",{attrs:{id:"resultContainer"}},[a("div",{staticClass:"gpa"},[t._v("Conversion 1 "),a("span",[t._v(t._s(t.v1grade))])]),a("dir",{staticClass:"gpa"},[t._v("Conversion 2 "),a("span",[t._v(t._s(t.v2grade))])])],1),a("div",{staticClass:"send2phone"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.phone,expression:"phone"}],staticStyle:{width:"60%",float:"left"},attrs:{type:"text"},domProps:{value:t.phone},on:{input:function(e){e.target.composing||(t.phone=e.target.value)}}}),a("button",{staticStyle:{float:"right"}},[t._v("SEND TO PHONE")])]),t._m(2),a("h3",[t._v("GPA Planning Calculator")]),a("p",[t._v("The calculator can be used to determine the minimum GPA required in the future courses to raise GAP to a desited level.")]),a("div",{staticClass:"gpa gpablk"},[a("div",{staticStyle:{width:"60%",float:"left","margin-right":"5%"}},[t._v("Current GPA")]),a("input",{directives:[{name:"model",rawName:"v-model",value:t.v1grade,expression:"v1grade"}],staticStyle:{width:"35%",float:"right"},attrs:{type:"text"},domProps:{value:t.v1grade},on:{input:function(e){e.target.composing||(t.v1grade=e.target.value)}}})]),a("div",{staticClass:"gpa gpablk"},[a("div",{staticStyle:{width:"60%",float:"left","margin-right":"5%"}},[t._v("Target GPA")]),a("input",{directives:[{name:"model",rawName:"v-model",value:t.targetGPA,expression:"targetGPA"}],staticStyle:{width:"35%",float:"right"},attrs:{type:"text"},domProps:{value:t.targetGPA},on:{input:function(e){e.target.composing||(t.targetGPA=e.target.value)}}})]),a("div",{staticClass:"gpa gpablk"},[a("div",{staticStyle:{width:"60%",float:"left","margin-right":"5%"}},[t._v("Current Credits")]),a("input",{directives:[{name:"model",rawName:"v-model",value:t.curCredits,expression:"curCredits"}],staticStyle:{width:"35%",float:"right"},attrs:{type:"text"},domProps:{value:t.curCredits},on:{input:function(e){e.target.composing||(t.curCredits=e.target.value)}}})]),a("div",{staticClass:"gpa gpablk"},[a("div",{staticStyle:{width:"60%",float:"left","margin-right":"5%"}},[t._v("Future Credits")]),a("input",{directives:[{name:"model",rawName:"v-model",value:t.furCredits,expression:"furCredits"}],staticStyle:{width:"35%",float:"right"},attrs:{type:"text"},domProps:{value:t.furCredits},on:{input:function(e){e.target.composing||(t.furCredits=e.target.value)}}})]),a("p",{attrs:{id:"plan"}},[t._v("To achieve a target GPA of "),a("span",[t._v(t._s(t.targetGPA))]),t._v(", the GPA for the next "),a("span",[t._v(t._s(t.furCredits))]),t._v(" credits needs to be "),a("span",[t._v(t._s(t.plannedGPA))]),t._v(" or hight.")])])},_=[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("span",{staticStyle:{"font-size":"1.2em"}},[t._v("Formula")]),a("span",{staticStyle:{float:"right"}},[t._v("GPA=Σ(Credit*Grade)/ΣCredit")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("table",{staticStyle:{width:"170px",float:"left"}},[a("tr",[a("td",{staticClass:"tg-baqh",staticStyle:{width:"50px"}},[t._v("A+")]),a("td",{staticClass:"tg-baqh",staticStyle:{width:"80px"}},[t._v("97-100")]),a("td",{staticClass:"tg-baqh",staticStyle:{width:"50px"}},[t._v("4.0")])]),a("tr",[a("td",{staticClass:"tg-baqh"},[t._v("A")]),a("td",{staticClass:"tg-baqh"},[t._v("93-96")]),a("td",{staticClass:"tg-baqh"},[t._v("4.0")])]),a("tr",[a("td",{staticClass:"tg-baqh"},[t._v("A-")]),a("td",{staticClass:"tg-baqh"},[t._v("90-92")]),a("td",{staticClass:"tg-baqh"},[t._v("3.7")])]),a("tr",[a("td",{staticClass:"tg-baqh"},[t._v("B+")]),a("td",{staticClass:"tg-baqh"},[t._v("87-89")]),a("td",{staticClass:"tg-baqh"},[t._v("3.3")])]),a("tr",[a("td",{staticClass:"tg-baqh"},[t._v("B")]),a("td",{staticClass:"tg-baqh"},[t._v("83-86")]),a("td",{staticClass:"tg-nrix"},[t._v("3.0")])]),a("tr",[a("td",{staticClass:"tg-baqh"},[t._v("B-")]),a("td",{staticClass:"tg-baqh"},[t._v("80-82")]),a("td",{staticClass:"tg-baqh"},[t._v("2.7")])]),a("tr",[a("td",{staticClass:"tg-baqh"},[t._v("C+")]),a("td",{staticClass:"tg-baqh"},[t._v("77-79")]),a("td",{staticClass:"tg-baqh"},[t._v("2.3")])]),a("tr",[a("td",{staticClass:"tg-baqh"},[t._v("C")]),a("td",{staticClass:"tg-baqh"},[t._v("73-76")]),a("td",{staticClass:"tg-baqh"},[t._v("2.0")])]),a("tr",[a("td",{staticClass:"tg-baqh"},[t._v("C-")]),a("td",{staticClass:"tg-baqh"},[t._v("70-72")]),a("td",{staticClass:"tg-baqh"},[t._v("1.7")])]),a("tr",[a("td",{staticClass:"tg-baqh"},[t._v("D+")]),a("td",{staticClass:"tg-baqh"},[t._v("67-69")]),a("td",{staticClass:"tg-baqh"},[t._v("1.3")])]),a("tr",[a("td",{staticClass:"tg-baqh"},[t._v("D")]),a("td",{staticClass:"tg-baqh"},[t._v("65-66")]),a("td",{staticClass:"tg-baqh"},[t._v("1.0")])]),a("tr",[a("td",{staticClass:"tg-baqh"},[t._v("D-")]),a("td",{staticClass:"tg-baqh"},[t._v("60-64")]),a("td",{staticClass:"tg-baqh"},[t._v("0.7")])]),a("tr",[a("td",{staticClass:"tg-baqh"},[t._v("F")]),a("td",{staticClass:"tg-baqh"},[t._v("<60")]),a("td",{staticClass:"tg-baqh"},[t._v("0.0")])])]),a("table",{staticStyle:{width:"170px",float:"right","padding-bottom":"160px"}},[a("tr",[a("td",{staticClass:"tg-0lax",staticStyle:{width:"50px"}},[t._v("A")]),a("td",{staticClass:"tg-baqh",staticStyle:{width:"80px"}},[t._v("90-100")]),a("td",{staticClass:"tg-baqh",staticStyle:{width:"50px"}},[t._v("4.0")])]),a("tr",[a("td",{staticClass:"tg-0lax"},[t._v("B")]),a("td",{staticClass:"tg-baqh"},[t._v("80-90")]),a("td",{staticClass:"tg-nrix"},[t._v("3.0")])]),a("tr",[a("td",{staticClass:"tg-0lax"},[t._v("C")]),a("td",{staticClass:"tg-baqh"},[t._v("70-80")]),a("td",{staticClass:"tg-baqh"},[t._v("2.0")])]),a("tr",[a("td",{staticClass:"tg-0lax"},[t._v("D")]),a("td",{staticClass:"tg-baqh"},[t._v("60-70")]),a("td",{staticClass:"tg-baqh"},[t._v("1.0")])]),a("tr",[a("td",{staticClass:"tg-0lax"},[t._v("F")]),a("td",{staticClass:"tg-baqh"},[t._v("<60")]),a("td",{staticClass:"tg-baqh"},[t._v("0.0")])]),a("tr",[a("td",{staticClass:"tg-0lax"},[t._v("P")]),a("td",{staticClass:"tg-baqh"},[t._v("--")]),a("td",{staticClass:"tg-baqh"},[t._v("DNC")])]),a("tr",[a("td",{staticClass:"tg-0lax"},[t._v("S")]),a("td",{staticClass:"tg-baqh"},[t._v("--")]),a("td",{staticClass:"tg-baqh"},[t._v("DNC")])])])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"genReport"},[a("button",[t._v("GENERATE REPORT ")])])}],f={props:{courses:Array},data:function(){return{v1grade:3.6,v2grade:3.8,phone:"+86 188 1356 4321",targetGPA:3.8,curCredits:10,furCredits:50,plannedGPA:3.9}}},b=f,C=(a("55be"),Object(v["a"])(b,h,_,!1,null,"7e9ced4b",null)),m=C.exports,y={name:"HelloWorld",components:{addCourseTable:p,resultDisplay:m},props:{msg:String},data:function(){return{courses:[{name:"Linear Algebra",credits:3,letterGrade:"B-",percentage:83.66,gradepts:3},{name:"Linear Algebra",credits:3,letterGrade:"B-",percentage:83.66,gradepts:3},{name:"Linear Algebra",credits:3,letterGrade:"B-",percentage:83.66,gradepts:3},{name:"Linear Algebra",credits:3,letterGrade:"B-",percentage:83.66,gradepts:3},{name:"Linear Algebra",credits:3,letterGrade:"B-",percentage:83.66,gradepts:3},{name:"Linear Algebra",credits:3,letterGrade:"B-",percentage:83.66,gradepts:3}]}}},q=y,x=(a("077e"),Object(v["a"])(q,n,l,!1,null,"1b794d32",null)),w=x.exports,P={name:"app",components:{mainBlock:w}},A=P,G=(a("034f"),Object(v["a"])(A,r,i,!1,null,null,null)),S=G.exports;s["a"].config.productionTip=!1,new s["a"]({render:function(t){return t(S)}}).$mount("#app")},"85ec":function(t,e,a){},"8bde":function(t,e,a){},dfcc:function(t,e,a){}});
//# sourceMappingURL=app.0e81027b.js.map