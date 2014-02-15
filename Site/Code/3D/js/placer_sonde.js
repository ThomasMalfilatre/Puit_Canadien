function placer_sonde(nom, x, y, z, r, g, b){
	var sondeGeo = new THREE.SphereGeometry( 10, 32, 16 ); 	
	var sondeMat = new THREE.MeshLambertMaterial( {color: "rgb("+r+","+g+","+b+")"} );
	var sonde = new THREE.Mesh(sondeGeo, sondeMat);
	sonde.position.set(x, y, z);
	sonde.name = "Sonde "+nom;
	scene.add(sonde);

	targetList.push(sonde);
}