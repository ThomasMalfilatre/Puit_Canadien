function placer_puit(){

	var sphereGeometry = new THREE.SphereGeometry( 10, 32, 16 ); 	
	var mat = new THREE.MeshBasicMaterial( {color: "rgb(0,0,0)", wireframe:true} );
	var mesh = new THREE.Mesh(sphereGeometry, mat);
	var mesh1 = new THREE.Mesh(sphereGeometry, mat);
	var mesh2 = new THREE.Mesh(sphereGeometry, mat);
	mesh.position.set(850,-50,550);
	mesh1.position.set(-200,-400,550);
	mesh2.position.set(-850,-50, 550);
	mesh.name = "Puit Canadien";
	mesh1.name = "Puit Canadien";
	mesh2.name = "Puit Canadien";
	scene.add(mesh);
	scene.add(mesh1);
	scene.add(mesh2);

	var Geo = new THREE.CylinderGeometry(10, 10, 200, 8, 1, true); 
	var Geo2 = new THREE.CylinderGeometry(10, 10, 1106.8, 8, 1, true); 
	var Geo3 = new THREE.CylinderGeometry(10, 10, 738.24, 8, 1, true); 
	var p = new THREE.Mesh(Geo, mat);
	p.position.set(850,50,550);
	p.name = "Puit Canadien";
	scene.add(p);
	var p1 = new THREE.Mesh(Geo2, mat);
	p1.position.set(325,-225,550);
	p1.rotation.z = 108.43 * (Math.PI / 180);
	p1.name = "Puit Canadien";
	scene.add(p1);
	var p2 = new THREE.Mesh(Geo3, mat);
	p2.position.set(-525,-225,550);
	p2.rotation.z = -118.3 * (Math.PI / 180);
	p2.name = "Puit Canadien";
	scene.add(p2);
	var p3 = new THREE.Mesh(Geo, mat);
	p3.position.set(-850,50,550);
	p3.name = "Puit Canadien";
	scene.add(p3);
}