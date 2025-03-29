<header>
    <style>
        html,
        body {
            margin: 0;
            height: 100%;
        }
        #c {
            width: 100%;
            height: 100%;
            display: block;
        }
    </style>
    </head>
    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">Sobre nós</h3>
                    <ul class="breadcrumb-tree">
                        <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=home">Casa</a></li>
                        <li class="active">Sobre nós</li>
                    </ul>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /BREADCRUMB -->
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <div class="col-md-7">
                    <!-- Billing Details -->
                    <div class="billing-details">
                        <div class="section-title">
                            <h3 class="title">
                                <img src="../img/logo/koop-logo.png" alt="">
                            </h3>
                        </div>
                        <p>Koop é um e-commerce Angolano desenvolvido pelo Koop(Empresa de tecnologia de software).</p>
                        <nav>
                            <h5>Linhas de produtos que o koop vende:</h5>
                            <ol>
                                <li><i class="fa fa-check" style="color:greenyellow;"></i> Tv's</li>
                                <li><i class="fa fa-check" style="color:greenyellow;"></i> Alimentos</li>
                                <li><i class="fa fa-check" style="color:greenyellow;"></i> Vestuários</li>
                                <li><i class="fa fa-check" style="color:greenyellow;"></i> Smartphone</li>
                                <li><i class="fa fa-check" style="color:greenyellow;"></i> Mobílias</li>
                                <li><i class="fa fa-check" style="color:greenyellow;"></i> Ferramentas</li>
                                <li><i class="fa fa-check" style="color:greenyellow;"></i> Utensílios plásticos</li>
                                <li><i class="fa fa-check" style="color:greenyellow;"></i> Produtos para crianças</li>
                                <li><i class="fa fa-check" style="color:greenyellow;"></i> Electrodomésticos</li>
                                <li><i class="fa fa-check" style="color:greenyellow;"></i> Produtos de beleza</li>
                                <li><i class="fa fa-check" style="color:greenyellow;"></i> Produtos de higiene</li>
                                <li><i class="fa fa-check" style="color:greenyellow;"></i> Artigos de cozinha</li>
                                <li><i class="fa fa-check" style="color:greenyellow;"></i> Instrumentos musicais</li>
                                <li><i class="fa fa-check" style="color:greenyellow;"></i> Aparelhos de son</li>
                                <li><i class="fa fa-check" style="color:greenyellow;"></i> Acessórios pessoais(joias, relógios...)</li>
                                <li><i class="fa fa-check" style="color:greenyellow;"></i> etc.</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- /Billing Details -->
                </div>
                <br><br><br><br>
                <!-- Order Details -->
                <div class="col-md-5 order-detail">
                    <div class="order-summary">
                        <body>
                            <canvas id="c"></canvas>
                        </body>
                        <script src="../js/three.min.js"></script>
                        <script>
                            'use strict';
                            /* global THREE */
                            function main() {
                                const canvas = document.querySelector('#c');
                                const renderer = new THREE.WebGLRenderer({
                                    canvas
                                });
                                const left = 0;
                                const right = 300; // default canvas size
                                const top = 0;
                                const bottom = 150; // defautl canvas size
                                const near = -1;
                                const far = 1;
                                const camera = new THREE.OrthographicCamera(left, right, top, bottom, near, far);
                                camera.zoom = 1;

                                const scene = new THREE.Scene();
                                scene.background = new THREE.Color('white');

                                const loader = new THREE.TextureLoader();
                                const textures = [
                                    loader.load('../img/sobre-nos/logo-koop-animacao.png'),
                                ];
                                const planeSize = 136;
                                const planeGeo = new THREE.PlaneBufferGeometry(planeSize, 70);
                                const planes = textures.map((texture) => {
                                    const planePivot = new THREE.Object3D();
                                    scene.add(planePivot);
                                    texture.magFilter = THREE.NearestFilter;
                                    const planeMat = new THREE.MeshBasicMaterial({
                                        map: texture,
                                        side: THREE.DoubleSide,
                                    });
                                    const mesh = new THREE.Mesh(planeGeo, planeMat);
                                    planePivot.add(mesh);
                                    // move plane so top left corner is origin
                                    mesh.position.set(planeSize / 2, planeSize / 2, 0);
                                    return planePivot;
                                });

                                function resizeRendererToDisplaySize(renderer) {
                                    const canvas = renderer.domElement;
                                    const width = canvas.clientWidth;
                                    const height = canvas.clientHeight;
                                    const needResize = canvas.width !== width || canvas.height !== height;
                                    if (needResize) {
                                        renderer.setSize(width, height, false);
                                    }
                                    return needResize;
                                }

                                function render(time) {
                                    time *= 0.0003; // convert to seconds;

                                    if (resizeRendererToDisplaySize(renderer)) {
                                        camera.right = canvas.width;
                                        camera.bottom = canvas.height;
                                        camera.updateProjectionMatrix();
                                    }

                                    const xRange = Math.max(20, canvas.width - planeSize) * 2;
                                    const yRange = Math.max(20, canvas.height - planeSize) * 2;

                                    planes.forEach((plane, ndx) => {
                                        const speed = 180;
                                        const t = time * speed + ndx * 300;
                                        const xt = t % xRange;
                                        const yt = t % yRange;

                                        const x = xt < xRange / 2 ? xt : xRange - xt;
                                        const y = yt < yRange / 2 ? yt : yRange - yt;

                                        plane.position.set(x, y, 0);
                                    });

                                    renderer.render(scene, camera);

                                    requestAnimationFrame(render);
                                }

                                requestAnimationFrame(render);
                            }

                            main();
                        </script>
                    </div>
                </div>
                <!-- /Order Details -->
            </div>
            <!-- /row -->
            <div class="row text-center">
                <div class="col-md-12">
                    <h3><i class="fa fa-group" style="color:#D10024"></i></h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-12">
                    <h3 style="font-family:monospace;">Equipa</h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-6">
                    <img src="../img/sobre-nos/teca.png" class="img-circle img-thumbnail" alt="">
                    <p style="color:gray"><strong>António Teca</strong></p>
                    <h6 style="color:black;">Desenvolvedor Fullstack</h6>
                </div>
                <div class="col-md-6">
                    <img src="../img/sobre-nos/austin.png" class="img-circle img-thumbnail" alt="">
                    <p style="color:gray"><strong>Austin Joaquim</strong></p>
                    <h6 style="color:black;">Desenvolvedor Fullstack</h6>
                </div>
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->