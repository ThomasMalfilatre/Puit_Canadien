/*** MAIN ***/

// declaration des variable globale

var container, scene, camera, renderer, controls, stats;
var keyboard = new THREEx.KeyboardState();
var clock = new THREE.Clock();
var cube;

var SCREEN_WIDTH = window.innerWidth;
var SCREEN_HEIGHT = window.innerHeight; 
var VIEW_ANGLE = 45;
var ASPECT = SCREEN_WIDTH / SCREEN_HEIGHT;
var NEAR = 0.1;
var FAR = 20000;

var projector, projector2, mouse = { x: 0, y: 0 }, INTERSECTED;
var sprite1;
var canvas1, context1, texture1;
var targetList = []; // liste des selectionnable
var selected = []; // liste des sondes selectionne

/*** INITIALISATION ***/
init();

/*** ANIMATION (BOUCLE)***/
animate();

/*** FONCTIONS ***/

function unset(array, value){
	var output=[];
	var index = array.indexOf(value)
	var j = 0;
	for(var i in array){
		if (i!=index){
			output[j]=array[i];
			j++;
		}
	}
	return output;
}

function init(){

	// scene
	scene = new THREE.Scene();

	// camera

	camera = new THREE.PerspectiveCamera( VIEW_ANGLE, ASPECT, NEAR, FAR);
	scene.add(camera);
	camera.position.set(0,800,1500);
	camera.lookAt(scene.position);	

	// renderer
	if ( Detector.webgl )
		renderer = new THREE.WebGLRenderer( {antialias:true} );
	else
		renderer = new THREE.CanvasRenderer(); 

	renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
	// attache le rendu a la div container
	container = document.getElementById( 'container' );
	container.appendChild( renderer.domElement );

	// events
	// ajuste automatiquement le rendu si on redimensionne la fenetre
	THREEx.WindowResize(renderer, camera);
	// plein ecran quand m est presser
	THREEx.FullScreen.bindKey({ charCode : 'm'.charCodeAt(0) });

	// controls

	// move mouse and: left   click to rotate, 
	//                 middle click to zoom, 
	//                 right  click to pan
	controls = new THREE.OrbitControls( camera, renderer.domElement );

	// stats

	stats = new Stats();
	stats.domElement.style.position = 'absolute';
	stats.domElement.style.bottom = '0px';
	stats.domElement.style.zIndex = 100;
	container.appendChild( stats.domElement );

	// light

	var light = new THREE.PointLight(0xffffff);
	light.position.set(0,250,1000);
	scene.add(light);

	//axes
	var axes = new THREE.AxisHelper(500);
	scene.add( axes );

	// sol

	var floorMaterial = new THREE.MeshBasicMaterial({color:"rgb(139,105,20)", side: THREE.DoubleSide});
	var floorGeometry = new THREE.PlaneGeometry(1800, 600, 1, 1);
	var floorGeometryArr = new THREE.PlaneGeometry(1800, 420, 1, 1);
	var floor = new THREE.Mesh(floorGeometry, floorMaterial);
	var fond = new THREE.Mesh(floorGeometry, floorMaterial);
	var arriere = new THREE.Mesh(floorGeometryArr, floorMaterial);
	floor.position.set(0,-0.5,300);
	floor.rotation.x = Math.PI / 2;
	scene.add(floor);
	fond.position.set(0,-420,300);
	fond.rotation.x = Math.PI / 2;
	scene.add(fond);
	arriere.position.set(0,-210,0);
	scene.add(arriere);


	// initialize object to perform world/screen calculations
	projector = new THREE.Projector();
	// when the mouse moves, call the given function
	document.addEventListener( 'mousemove', onDocumentMouseMove, false );
	/////// draw text on canvas /////////
	// create a canvas element
	canvas1 = document.createElement('canvas');
	context1 = canvas1.getContext('2d');
	context1.font = "Bold 20px Arial";
	context1.fillStyle = "rgba(0,0,0,0.95)";
    context1.fillText('Hello, world!', 0, 20);
	// canvas contents will be used for a texture
	texture1 = new THREE.Texture(canvas1) 
	texture1.needsUpdate = true;
	////////////////////////////////////////
	var spriteMaterial = new THREE.SpriteMaterial( { map: texture1, useScreenCoordinates: true, alignment: THREE.SpriteAlignment.topLeft } );
	sprite1 = new THREE.Sprite( spriteMaterial );
	sprite1.scale.set(200,100,1.0);
	sprite1.position.set( 50, 50, 0 );
	scene.add( sprite1 );	
	//////////////////////////////////////////

	projector2 = new THREE.Projector();
	document.addEventListener( 'mousedown', onDocumentMouseDown, false);
}

function onDocumentMouseMove( event ){
	// the following line would stop any other event handler from firing
	// (such as the mouse's TrackballControls)
	// event.preventDefault();

	// update sprite position
	sprite1.position.set( event.clientX, event.clientY - 20, 0 );

	// update the mouse variable
	mouse.x = ( event.clientX / window.innerWidth ) * 2 - 1;
	mouse.y = - ( event.clientY / window.innerHeight ) * 2 + 1;
}

function onDocumentMouseDown( event ){
	// the following line would stop any other event handler from firing
	// (such as the mouse's TrackballControls)
	// event.preventDefault();

	console.log("Click.");

	// update the mouse variable
	mouse.x = ( event.clientX / window.innerWidth ) * 2 - 1;
	mouse.y = - ( event.clientY / window.innerHeight ) * 2 + 1;

	// find intersections

	// create a Ray with origin at the mouse position
	//   and direction into the scene (camera direction)
	var vector = new THREE.Vector3( mouse.x, mouse.y, 1 );
	projector2.unprojectVector( vector, camera );
	var ray = new THREE.Raycaster( camera.position, vector.sub( camera.position ).normalize() );

	// create an array containing all objects in the scene with which the ray intersects
	var intersects = ray.intersectObjects( targetList );

	// if there is one (or more) intersections
	if ( intersects.length > 0 ){
		console.log("Hit @ " + toString( intersects[0].point ) );
		console.log(intersects[0].object.name);

		intersects[ 0 ].object.material.color.setRGB( 0, 0, 0 );
		intersects[ 0 ].object.geometry.colorsNeedUpdate = true;
		
		var trouve = false;
		for(var i=0;i<selected.length;i++)
			if(intersects[0].object.name == selected[i].name)
				trouve = true;

		if(!trouve)
			selected.push(intersects[0].object);
		else
			selected = unset(selected, intersects[0].object);

		var str = "";
		for(var i=0;i<selected.length;i++)
			str += selected[i].name + "\n";
		alert(str);	 
	}
}
function toString(v) { return "[ " + v.x + ", " + v.y + ", " + v.z + " ]"; }

function animate(){
    requestAnimationFrame( animate );
	render();		
	update();
}

function update(){
	// delta = change in time since last call (in seconds)
	var delta = clock.getDelta(); 

	// create a Ray with origin at the mouse position
	//   and direction into the scene (camera direction)
	var vector = new THREE.Vector3( mouse.x, mouse.y, 1 );
	projector.unprojectVector( vector, camera );
	var ray = new THREE.Raycaster( camera.position, vector.sub( camera.position ).normalize() );
	// create an array containing all objects in the scene with which the ray intersects
	var intersects = ray.intersectObjects( scene.children );
	// INTERSECTED = the object in the scene currently closest to the camera 
	//		and intersected by the Ray projected from the mouse position 	
	// if there is one (or more) intersections
	if ( intersects.length > 0 ){
		// if the closest object intersected is not the currently stored intersection object
		if ( intersects[ 0 ].object != INTERSECTED ){
		    // restore previous intersection object (if it exists) to its original color
			if ( INTERSECTED ) 
				INTERSECTED.material.color.setHex( INTERSECTED.currentHex );
			// store reference to closest object as current intersection object
			INTERSECTED = intersects[ 0 ].object;
			// store color of closest object (for later restoration)
			INTERSECTED.currentHex = INTERSECTED.material.color.getHex();
			// set a new color for closest object

			// update text, if it has a "name" field.
			if ( intersects[ 0 ].object.name ){
				INTERSECTED.material.color.setHex( 0xffffff );
			    context1.clearRect(0,0,640,480);
				var message = intersects[ 0 ].object.name;
				var metrics = context1.measureText(message);
				var width = metrics.width;
				context1.fillStyle = "rgba(0,0,0,0.95)"; // black border
				context1.fillRect( 0,0, width+8,20+8);
				context1.fillStyle = "rgba(255,255,255,0.95)"; // white filler
				context1.fillRect( 2,2, width+4,20+4 );
				context1.fillStyle = "rgba(0,0,0,1)"; // text color
				context1.fillText( message, 4,20 );
				texture1.needsUpdate = true;
			}
			else{
				context1.clearRect(0,0,300,300);
				texture1.needsUpdate = true;
			}
		}
	} 
	else{ // there are no intersections
		// restore previous intersection object (if it exists) to its original color
		if ( INTERSECTED ) 
			INTERSECTED.material.color.setHex( INTERSECTED.currentHex );
		// remove previous intersection object reference
		//     by setting current intersection object to "nothing"
		INTERSECTED = null;
		context1.clearRect(0,0,300,300);
		texture1.needsUpdate = true;
	}

	controls.update();
	stats.update();
}

function render(){	
	renderer.render( scene, camera );
}
