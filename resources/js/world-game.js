export function mountWorldGame(board) {
    const shell = document.querySelector('[data-game-shell]');
    const canvas = board.querySelector('[data-game-world-canvas]');
    const ctx = canvas?.getContext('2d');
    if (!ctx) return;

    const $ = (selector) => document.querySelector(selector);
    const scoreEl = $('[data-game-score]');
    const timeEl = $('[data-game-time]');
    const levelEl = $('[data-game-level]');
    const hpEl = $('[data-game-hp]');
    const comboEl = $('[data-game-combo]');
    const missionEl = $('[data-game-mission]');
    const dashEl = $('[data-game-dash]');
    const bestEl = $('[data-game-best]');
    const statusEl = $('[data-game-status]');
    const targetHint = $('[data-game-target-hint]');
    const worldEl = $('[data-game-world]');
    const mechanicEl = $('[data-game-world-mechanic]');
    const powerEl = $('[data-game-power]');
    const chargeEl = $('[data-game-overdrive-label]');
    const fillEl = $('[data-game-overdrive-fill]');
    const chargeBar = $('[data-game-overdrive-bar]');
    const startButton = $('[data-game-action]');
    const dashButton = $('[data-game-dash-action]');
    const overdriveButton = $('[data-game-overdrive-action]');
    const pauseButton = $('[data-game-pause]');
    const fullButton = $('[data-game-fullscreen]');
    const musicButton = $('[data-game-music]');
    const pauseOverlay = $('[data-game-pause-overlay]');
    const resumeButton = $('[data-game-resume]');
    const summary = $('[data-game-summary-overlay]');
    const summaryStats = $('[data-game-summary-stats]');
    const achievements = $('[data-game-achievements]');
    const progress = $('[data-game-progress]');
    const restart = $('[data-game-restart]');
    const tutorial = $('[data-game-tutorial-overlay]');
    const tutorialNext = $('[data-game-tutorial-next]');
    const tutorialSkip = $('[data-game-tutorial-skip]');
    const musicRange = $('[data-game-music-volume]');
    const sfxRange = $('[data-game-sfx-volume]');
    const musicLabel = $('[data-game-music-value]');
    const sfxLabel = $('[data-game-sfx-value]');

    const zones = [
        { name: 'NEON CITY', note: 'Jelajahi jalan dan kumpulkan kristal', sky: '#101d32', floor: '#18283b', grid: '#32d9e8', block: '#167e98', accent: '#57f2ff' },
        { name: 'SUNSET DUNES', note: 'Pasir bergerak · jalur makin terbuka', sky: '#42283b', floor: '#57384b', grid: '#ffb46b', block: '#b85642', accent: '#ffcc72' },
        { name: 'MOSSY RUINS', note: 'Reruntuhan hijau · penjaga lebih banyak', sky: '#172f2b', floor: '#24463b', grid: '#84e3a1', block: '#34705b', accent: '#9dffb5' },
        { name: 'FROST PEAK', note: 'Puncak es · lantai licin', sky: '#1b2c47', floor: '#344b67', grid: '#a8d9ff', block: '#5886b4', accent: '#b9e8ff' },
        { name: 'VOID TEMPLE', note: 'Zona akhir · portal dan penjaga kuat', sky: '#241d3d', floor: '#35294c', grid: '#d3a8ff', block: '#754e9f', accent: '#e0b7ff' },
    ];
    const keys = new Set();
    const player = { x: 0, z: 0, y: 0, vy: 0, yaw: 0, hp: 3, score: 0, charge: 0, shields: 0, dash: 0, invulnerable: 0, combo: 1, lastPickup: -10 };
    const world = { objects: [], time: 0, elapsed: 0, started: false, paused: false, ended: false, last: 0, level: 0, mission: 0, target: 4, portalUnlocked: false, dashCooldown: 0, overdrive: 0, best: Number(localStorage.getItem('portfolio-geometry-runner-best') || 0) };
    let audioContext;
    let musicOn = true;
    let resizeObserver;

    bestEl.textContent = `Terbaik: ${world.best}`;
    const resize = () => {
        const rect = board.getBoundingClientRect();
        const dpr = Math.min(window.devicePixelRatio || 1, 2);
        canvas.width = Math.max(1, Math.round(rect.width * dpr));
        canvas.height = Math.max(1, Math.round(rect.height * dpr));
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    };
    resizeObserver = new ResizeObserver(resize);
    resizeObserver.observe(board);
    resize();

    const zoneIndex = () => Math.min(zones.length - 1, Math.floor(Math.max(0, player.x + 10) / 24));
    const currentZone = () => zones[zoneIndex()];
    const setStatus = (text) => { statusEl.textContent = text; };
    const tone = (frequency = 440, duration = .12, type = 'sine') => {
        if (!musicOn) return;
        try {
            audioContext ||= new (window.AudioContext || window.webkitAudioContext)();
            if (audioContext.state === 'suspended') audioContext.resume();
            const oscillator = audioContext.createOscillator();
            const gain = audioContext.createGain();
            oscillator.type = type;
            oscillator.frequency.value = frequency;
            gain.gain.setValueAtTime(.055, audioContext.currentTime);
            gain.gain.exponentialRampToValueAtTime(.001, audioContext.currentTime + duration);
            oscillator.connect(gain).connect(audioContext.destination);
            oscillator.start(); oscillator.stop(audioContext.currentTime + duration);
        } catch { /* Audio is optional. */ }
    };
    const makeObject = (type, x, z, extra = {}) => ({ type, x, z, y: 0, phase: Math.random() * 8, active: true, ...extra });

    const resetWorld = () => {
        world.objects = [];
        for (let x = -10; x < 115; x += 7) {
            for (let z = -18; z <= 18; z += 7) {
                const rockX = x + Math.random() * 3;
                const rockZ = z + Math.random() * 3;
                if (Math.random() < .23 && Math.hypot(rockX - player.x, rockZ - player.z) > 6) {
                    world.objects.push(makeObject('rock', rockX, rockZ, { size: 1.2 + Math.random() * 1.6 }));
                }
            }
        }
        for (let i = 0; i < 25; i++) world.objects.push(makeObject('crystal', 5 + i * 4 + Math.random() * 2, (Math.random() - .5) * 24));
        for (let i = 0; i < 16; i++) world.objects.push(makeObject('guardian', 14 + i * 6 + Math.random() * 2, (Math.random() - .5) * 22, { dir: Math.random() < .5 ? -1 : 1, hp: 1 }));
        for (let i = 0; i < 5; i++) world.objects.push(makeObject('portal', 20 + i * 22, 0));
        for (let i = 0; i < 9; i++) world.objects.push(makeObject(i % 3 ? 'shield' : 'heart', 12 + i * 11, (Math.random() - .5) * 16));
    };
    resetWorld();

    const project = (x, y, z) => {
        const width = board.clientWidth;
        const height = board.clientHeight;
        const dx = x - player.x;
        const dz = z - player.z;
        const forward = dx * Math.cos(player.yaw) + dz * Math.sin(player.yaw);
        const side = -dx * Math.sin(player.yaw) + dz * Math.cos(player.yaw);
        const focal = Math.min(width, height) * .78;
        const depth = Math.max(5, 19 - forward * .72);
        const scale = focal / depth;
        return { x: width * .5 + side * scale, y: height * .57 + ((19 - depth) * .35 - y) * scale, scale, depth };
    };
    const cube = (x, y, z, size, color, glow = null) => {
        const p = project(x, y, z);
        const s = Math.max(2, size * p.scale);
        if (p.x < -s * 3 || p.x > board.clientWidth + s * 3 || p.y < -s * 4 || p.y > board.clientHeight + s * 3) return;
        if (glow) { ctx.shadowColor = glow; ctx.shadowBlur = Math.min(30, s * .45); }
        ctx.fillStyle = color;
        ctx.beginPath(); ctx.moveTo(p.x, p.y - s); ctx.lineTo(p.x + s, p.y - s * .5); ctx.lineTo(p.x + s, p.y + s * .5); ctx.lineTo(p.x, p.y + s); ctx.lineTo(p.x - s, p.y + s * .5); ctx.lineTo(p.x - s, p.y - s * .5); ctx.closePath(); ctx.fill();
        ctx.fillStyle = 'rgba(255,255,255,.25)';
        ctx.beginPath(); ctx.moveTo(p.x, p.y - s); ctx.lineTo(p.x + s, p.y - s * .5); ctx.lineTo(p.x, p.y); ctx.lineTo(p.x - s, p.y - s * .5); ctx.closePath(); ctx.fill();
        ctx.fillStyle = 'rgba(0,0,0,.22)';
        ctx.beginPath(); ctx.moveTo(p.x, p.y); ctx.lineTo(p.x + s, p.y - s * .5); ctx.lineTo(p.x + s, p.y + s * .5); ctx.lineTo(p.x, p.y + s); ctx.closePath(); ctx.fill();
        ctx.shadowBlur = 0;
    };
    const draw = () => {
        const width = board.clientWidth;
        const height = board.clientHeight;
        const zone = currentZone();
        const sky = ctx.createLinearGradient(0, 0, 0, height);
        sky.addColorStop(0, zone.sky); sky.addColorStop(.58, '#101522'); sky.addColorStop(1, zone.floor);
        ctx.fillStyle = sky; ctx.fillRect(0, 0, width, height);
        // Horizon glow and distant voxel skyline.
        const horizon = ctx.createRadialGradient(width * .5, height * .43, 2, width * .5, height * .43, width * .65);
        horizon.addColorStop(0, `${zone.accent}30`); horizon.addColorStop(1, 'transparent');
        ctx.fillStyle = horizon; ctx.fillRect(0, 0, width, height);
        for (let i = 0; i < 18; i++) {
            const x = ((i * 97 - player.x * 8) % (width + 100) + width + 100) % (width + 100) - 50;
            const h = 18 + (i * 37 % 60);
            ctx.fillStyle = `${zone.block}70`; ctx.fillRect(x, height * .45 - h, 24 + (i % 3) * 11, h);
        }
        // Perspective voxel ground grid.
        ctx.lineWidth = 1;
        for (let z = -28; z <= 45; z += 4) {
            const left = project(player.x - 55, 0, z), right = project(player.x + 55, 0, z);
            ctx.strokeStyle = `${zone.grid}${z % 8 === 0 ? '55' : '24'}`;
            ctx.beginPath(); ctx.moveTo(left.x, left.y); ctx.lineTo(right.x, right.y); ctx.stroke();
        }
        for (let x = -52; x <= 52; x += 4) {
            const near = project(player.x + x, 0, -28), far = project(player.x + x, 0, 45);
            ctx.strokeStyle = `${zone.grid}30`; ctx.beginPath(); ctx.moveTo(near.x, near.y); ctx.lineTo(far.x, far.y); ctx.stroke();
        }
        const visible = world.objects.filter((o) => o.active && Math.abs(o.x - player.x) < 60 && Math.abs(o.z - player.z) < 42).sort((a, b) => b.z - a.z);
        for (const o of visible) {
            if (o.type === 'rock') cube(o.x, 0, o.z, o.size, zone.block);
            if (o.type === 'crystal') cube(o.x, 1.3 + Math.sin(world.time * 3 + o.phase) * .2, o.z, .48, '#67e8f9', '#22d3ee');
            if (o.type === 'guardian') {
                cube(o.x, .85 + Math.sin(world.time * 4 + o.phase) * .08, o.z, .8, '#fb7185', '#fb345f');
                cube(o.x, 1.65, o.z, .44, '#ffe4e6');
            }
            if (o.type === 'portal') {
                const p = project(o.x, 2.3 + Math.sin(world.time * 2 + o.phase) * .15, o.z);
                const r = Math.max(6, p.scale * 1.6);
                ctx.strokeStyle = zone.accent; ctx.lineWidth = Math.max(2, p.scale * .12); ctx.shadowColor = zone.accent; ctx.shadowBlur = 18;
                ctx.beginPath(); ctx.ellipse(p.x, p.y, r * .65, r, 0, 0, Math.PI * 2); ctx.stroke(); ctx.shadowBlur = 0;
                cube(o.x, 0, o.z, .4, zone.accent, zone.accent);
            }
            if (o.type === 'shield' || o.type === 'heart') cube(o.x, 1 + Math.sin(world.time * 3 + o.phase) * .14, o.z, .48, o.type === 'shield' ? '#60a5fa' : '#fb7185', o.type === 'shield' ? '#60a5fa' : '#fb7185');
        }
        const py = player.y;
        cube(player.x, py + .75, player.z, .8, world.dashCooldown > world.time ? '#67e8f9' : '#ff7a1a', '#f97316');
        cube(player.x, py + 1.55, player.z, .42, '#ffd7b0');
        const targets = world.objects.filter((o) => o.active && ['crystal', 'portal'].includes(o.type));
        const nearestCrystal = targets.filter((o) => o.type === 'crystal').sort((a, b) => Math.hypot(a.x - player.x, a.z - player.z) - Math.hypot(b.x - player.x, b.z - player.z))[0];
        const nextPortal = targets.filter((o) => o.type === 'portal').sort((a, b) => Math.hypot(a.x - player.x, a.z - player.z) - Math.hypot(b.x - player.x, b.z - player.z))[0];
        const markerTarget = world.portalUnlocked ? nextPortal : nearestCrystal;
        if (markerTarget) {
            const p = project(markerTarget.x, 2.1, markerTarget.z);
            const x = Math.max(24, Math.min(width - 24, p.x));
            const y = Math.max(45, Math.min(height - 64, p.y));
            ctx.strokeStyle = markerTarget.type === 'portal' ? '#f0abfc' : '#67e8f9';
            ctx.fillStyle = ctx.strokeStyle;
            ctx.lineWidth = 2;
            ctx.beginPath(); ctx.moveTo(x, y - 10); ctx.lineTo(x + 7, y + 5); ctx.lineTo(x - 7, y + 5); ctx.closePath(); ctx.fill();
            ctx.font = '700 10px ui-sans-serif'; ctx.textAlign = 'center';
            ctx.fillText(markerTarget.type === 'portal' ? 'PORTAL' : `KRISTAL · ${Math.round(Math.hypot(markerTarget.x - player.x, markerTarget.z - player.z))}m`, x, y - 16);
            ctx.textAlign = 'left';
        }
        // Center reticle and map compass.
        ctx.strokeStyle = `${zone.accent}aa`; ctx.lineWidth = 1.5; ctx.beginPath(); ctx.arc(width / 2, height * .57, 8, 0, Math.PI * 2); ctx.stroke();
        ctx.fillStyle = '#fff'; ctx.font = '600 10px ui-sans-serif'; ctx.fillText(`X ${Math.round(player.x)}  ·  Z ${Math.round(player.z)}`, 14, height - 16);
        ctx.fillStyle = zone.accent; ctx.textAlign = 'right'; ctx.fillText('WASD MOVE  ·  E INTERAKSI', width - 14, height - 16); ctx.textAlign = 'left';
    };

    const syncHud = () => {
        const zone = currentZone();
        scoreEl.textContent = player.score;
        timeEl.textContent = `${String(Math.floor(world.elapsed / 60)).padStart(2, '0')}:${String(Math.floor(world.elapsed % 60)).padStart(2, '0')}`;
        levelEl.textContent = world.level + 1;
        hpEl.textContent = `${'♥'.repeat(player.hp)}${'♡'.repeat(3 - player.hp)}`;
        hpEl.setAttribute('aria-label', `${player.hp} nyawa`);
        comboEl.textContent = `×${player.combo}`;
        missionEl.textContent = world.portalUnlocked ? 'Portal terbuka · tekan E' : `Kristal ${world.mission}/${world.target}`;
        dashEl.textContent = world.dashCooldown <= world.time ? 'Siap' : `${Math.ceil(world.dashCooldown - world.time)} dtk`;
        powerEl.textContent = `Perisai: ${player.shields}`;
        chargeEl.textContent = `Energi ${Math.floor(player.charge)}%`;
        fillEl.style.width = `${player.charge}%`;
        chargeBar.setAttribute('aria-valuenow', String(Math.floor(player.charge)));
        overdriveButton.disabled = player.charge < 100 || world.overdrive > world.time;
        worldEl.textContent = zone.name;
        mechanicEl.textContent = zone.note;
        bestEl.textContent = `Terbaik: ${world.best}`;
        if (targetHint) targetHint.textContent = world.portalUnlocked
            ? 'PORTAL TERBUKA · DEKATI LINGKARAN UNGU, LALU TEKAN E'
            : `TUJUAN · KUMPULKAN ${world.target - world.mission} KRISTAL CYAN LAGI`;
    };
    const collect = (o) => {
        o.active = false;
        if (o.type === 'crystal') {
            player.combo = world.elapsed - player.lastPickup < 5 ? Math.min(5, player.combo + 1) : 1;
            player.lastPickup = world.elapsed;
            player.score += 50 * player.combo;
            player.charge = Math.min(100, player.charge + 12);
            if (!world.portalUnlocked) world.mission += 1;
            setStatus(`Kristal didapat! +${50 * player.combo} · Combo ×${player.combo}`);
            tone(780 + player.combo * 80, .13, 'triangle');
            if (!world.portalUnlocked && world.mission >= world.target) {
                player.score += 250; player.charge = Math.min(100, player.charge + 20);
                world.portalUnlocked = true;
                setStatus('Misi selesai! +250 poin. Portal ungu terbuka — dekati lalu tekan E.'); tone(980, .35, 'sine');
            }
        } else if (o.type === 'guardian') {
            if (player.dash > world.time || world.overdrive > world.time) {
                player.score += 100; player.charge = Math.min(100, player.charge + 8); setStatus('Penjaga dikalahkan! +100'); tone(170, .2, 'square');
            } else { o.active = true; setStatus('Penjaga menghalangi jalan. Tekan E untuk mengalahkannya atau Dash menerobos.'); }
        } else if (o.type === 'shield') { player.shields = Math.min(2, player.shields + 1); player.score += 20; setStatus('Perisai ditemukan.'); tone(560, .2); }
        else if (o.type === 'heart') { player.hp = Math.min(3, player.hp + 1); setStatus('HP dipulihkan.'); tone(720, .2); }
        else if (o.type === 'portal') {
            player.score += 150; player.charge = Math.min(100, player.charge + 18); setStatus('Portal terbuka! Biome baru ditemukan.'); tone(440, .35, 'triangle');
            player.x = Math.min(112, player.x + 8);
            o.active = false;
            world.portalUnlocked = false; world.mission = 0; world.target = 4;
        }
        if (player.hp <= 0) finish();
        syncHud();
    };
    const finish = () => {
        world.ended = true; world.started = false; pauseButton.disabled = true; startButton.textContent = 'Jelajah lagi';
        world.best = Math.max(world.best, player.score);
        try { localStorage.setItem('portfolio-geometry-runner-best', String(world.best)); } catch { /* Ignore storage errors. */ }
        summaryStats.innerHTML = `<p class="rounded-lg bg-white/5 p-3">Skor <b>${player.score}</b></p><p class="rounded-lg bg-white/5 p-3">Waktu <b>${Math.floor(world.elapsed)} dtk</b></p><p class="rounded-lg bg-white/5 p-3">Biome <b>${currentZone().name}</b></p><p class="rounded-lg bg-white/5 p-3">Kristal <b>${Math.floor(player.score / 50)}</b></p>`;
        achievements.innerHTML = '<span class="rounded-full bg-cyan-400/15 px-3 py-1 text-cyan-200">Penjelajah voxel</span>';
        progress.textContent = `Rekor dunia: ${world.best} poin.`;
        summary.classList.remove('hidden'); summary.classList.add('flex');
        setStatus(`Petualangan berakhir · skor ${player.score}. Tekan Main lagi untuk memulai ulang.`);
    };
    const start = () => {
        if (!world.started) {
            if (world.ended) { player.x = 0; player.z = 0; player.y = 0; player.hp = 3; player.score = 0; player.charge = 0; player.shields = 0; player.combo = 1; world.elapsed = 0; world.time = 0; world.level = 0; world.mission = 0; world.portalUnlocked = false; world.ended = false; resetWorld(); }
            world.started = true; world.paused = false; pauseButton.disabled = false; pauseButton.textContent = 'Jeda (P)';
            summary.classList.add('hidden'); summary.classList.remove('flex'); tutorial.classList.add('hidden');
            startButton.textContent = 'Jelajah'; board.focus({ preventScroll: true }); setStatus('Jelajahi dunia! Cari kristal cyan dan dekati portal bercahaya.');
            tone(440, .14); world.last = performance.now(); requestAnimationFrame(frame);
        }
    };
    const jump = () => { if (!world.started) return start(); if (player.y <= .02) { player.vy = 7; tone(260, .1, 'triangle'); } };
    const dash = () => {
        if (!world.started) return start();
        if (world.dashCooldown > world.time) return;
        world.dashCooldown = world.time + 2.5; player.dash = world.time + .42; player.invulnerable = world.time + .42;
        player.x += Math.cos(player.yaw) * 3.2; player.z += Math.sin(player.yaw) * 3.2;
        setStatus('Voxel Dash! Kamu kebal sesaat dan bisa menerobos penjaga.'); tone(180, .1, 'sawtooth'); tone(640, .2, 'triangle'); syncHud();
    };
    const interact = () => {
        if (!world.started) return start();
        const nearest = world.objects.filter((o) => o.active && (o.type === 'portal' || o.type === 'guardian') && Math.hypot(o.x - player.x, o.z - player.z) < 2.8)
            .sort((a, b) => Math.hypot(a.x - player.x, a.z - player.z) - Math.hypot(b.x - player.x, b.z - player.z))[0];
        if (nearest?.type === 'guardian') { nearest.active = false; player.score += 80; player.charge = Math.min(100, player.charge + 10); setStatus('Penjaga dikalahkan! +80 poin dan energi.'); tone(700, .2, 'triangle'); syncHud(); }
        else if (nearest?.type === 'portal' && world.portalUnlocked) collect(nearest);
        else if (nearest?.type === 'portal') setStatus(`Portal terkunci · kumpulkan ${world.target - world.mission} kristal cyan lagi.`);
        else setStatus('Dekati penjaga atau portal sampai dekat, lalu tekan E.');
    };
    const togglePause = (force = false) => {
        if (!world.started) return;
        world.paused = force ? false : !world.paused;
        pauseOverlay.classList.toggle('hidden', !world.paused); pauseOverlay.classList.toggle('flex', world.paused);
        pauseButton.textContent = world.paused ? 'Lanjut (P)' : 'Jeda (P)';
        if (!world.paused) { world.last = performance.now(); requestAnimationFrame(frame); }
    };
    const frame = (now) => {
        if (!world.started || world.paused || world.ended) return;
        const dt = Math.min(.04, (now - world.last) / 1000 || 0); world.last = now; world.time += dt; world.elapsed += dt;
        const forward = Number(keys.has('w') || keys.has('arrowup')) - Number(keys.has('s') || keys.has('arrowdown'));
        const side = Number(keys.has('d') || keys.has('arrowright')) - Number(keys.has('a') || keys.has('arrowleft'));
        const boost = world.overdrive > world.time ? 1.6 : 1;
        const speed = (player.dash > world.time ? 15 : 6) * boost * dt;
        if (forward || side) {
            const length = Math.hypot(forward, side) || 1;
            const fx = Math.cos(player.yaw), fz = Math.sin(player.yaw);
            const nextX = player.x + (fx * forward + Math.cos(player.yaw + Math.PI / 2) * side) / length * speed;
            const nextZ = player.z + (fz * forward + Math.sin(player.yaw + Math.PI / 2) * side) / length * speed;
            const blocked = world.objects.some((o) => o.active && o.type === 'rock' && Math.hypot(o.x - nextX, o.z - nextZ) < o.size * .72);
            if (!blocked) { player.x = nextX; player.z = nextZ; }
        }
        player.x = Math.max(-6, Math.min(118, player.x)); player.z = Math.max(-20, Math.min(20, player.z));
        player.vy -= 19 * dt; player.y = Math.max(0, player.y + player.vy * dt); if (player.y === 0) player.vy = 0;
        if (world.overdrive > world.time) player.charge = Math.min(100, player.charge + dt * 5);
        world.level = Math.floor(player.x / 24);
        for (const o of world.objects) {
            if (!o.active) continue;
            if (o.type === 'guardian') { o.x += Math.sin(world.time * .8 + o.phase) * dt * 1.5; o.z += o.dir * dt * .8; if (Math.abs(o.z) > 18) o.dir *= -1; }
            const distance = Math.hypot(o.x - player.x, o.z - player.z);
            if (o.type === 'guardian' && distance < 1.3 && player.dash > world.time) collect(o);
            else if (o.type === 'guardian' && distance < 1.35 && player.invulnerable <= world.time) {
                player.invulnerable = world.time + 1.35;
                if (player.shields > 0) { player.shields -= 1; setStatus('Perisai menahan serangan penjaga. Tekan E untuk melawannya.'); }
                else { player.hp = Math.max(0, player.hp - 1); setStatus(`Penjaga menyerang! HP ${player.hp}/3 · tekan E untuk melawan.`); }
                syncHud(); tone(110, .22, 'sawtooth'); if (player.hp <= 0) finish();
            } else if (o.type === 'guardian' && distance < 2.2 && world.time - (o.lastNotice || -10) > 3) {
                o.lastNotice = world.time; setStatus('Penjaga di depan · hindari, Dash menembus, atau dekati dan tekan E.');
            } else if (o.type !== 'guardian' && o.type !== 'portal' && distance < 1.05) collect(o);
        }
        if (world.level >= zones.length - 1 && player.x > 116) { player.score += 500; player.x = 0; world.level = 0; world.portalUnlocked = false; world.mission = 0; resetWorld(); setStatus('Dunia diselesaikan! +500 · ekspedisi baru dimulai.'); }
        syncHud(); draw(); requestAnimationFrame(frame);
    };

    const toggleFullscreen = async () => {
        try { if (document.fullscreenElement === shell) await document.exitFullscreen(); else await shell.requestFullscreen(); }
        catch { setStatus('Fullscreen tidak diizinkan browser untuk halaman ini.'); }
    };
    document.addEventListener('fullscreenchange', () => { const full = document.fullscreenElement === shell; fullButton.textContent = full ? 'Keluar Fullscreen (F)' : 'Fullscreen (F)'; fullButton.setAttribute('aria-pressed', String(full)); resize(); });
    window.addEventListener('keydown', (event) => {
        const key = event.key.toLowerCase();
        if (['arrowup', 'arrowdown', 'arrowleft', 'arrowright', ' '].includes(key)) event.preventDefault();
        if (event.repeat && [' ', 'shift', 'e', 'x', 'p', 'f'].includes(key)) return;
        keys.add(key);
        if (key === ' ' || key === 'arrowup') jump();
        if (key === 'shift') dash();
        if (key === 'e') interact();
        if (key === 'x' && player.charge >= 100 && world.started) { player.charge = 0; world.overdrive = world.time + 7; setStatus('OVERDRIVE! Gerak lebih cepat dan kebal selama 7 detik.'); tone(220, .5, 'sawtooth'); }
        if (key === 'p') togglePause();
        if (key === 'f') toggleFullscreen();
    });
    window.addEventListener('keyup', (event) => keys.delete(event.key.toLowerCase()));
    let dragX = null;
    board.addEventListener('pointerdown', (event) => { if (event.target.closest('button, input, summary')) return; board.focus({ preventScroll: true }); dragX = event.clientX; if (!world.started) start(); });
    board.addEventListener('pointermove', (event) => { if (dragX === null) return; player.yaw += (event.clientX - dragX) * .008; dragX = event.clientX; });
    window.addEventListener('pointerup', () => { dragX = null; });
    window.addEventListener('pointercancel', () => { dragX = null; });
    board.querySelectorAll('[data-world-key]').forEach((button) => {
        const key = button.dataset.worldKey;
        button.addEventListener('pointerdown', (event) => { event.preventDefault(); keys.add(key); button.setPointerCapture?.(event.pointerId); });
        ['pointerup', 'pointercancel', 'lostpointercapture'].forEach((name) => button.addEventListener(name, () => keys.delete(key)));
    });
    board.querySelectorAll('[data-world-action]').forEach((button) => button.addEventListener('click', () => button.dataset.worldAction === 'jump' ? jump() : dash()));
    startButton.addEventListener('click', () => { if (!world.started) start(); else jump(); }); dashButton.addEventListener('click', dash); overdriveButton.addEventListener('click', () => { if (player.charge >= 100) { player.charge = 0; world.overdrive = world.time + 7; setStatus('OVERDRIVE aktif · kebal dan lebih cepat!'); } });
    pauseButton.addEventListener('click', () => togglePause()); resumeButton.addEventListener('click', () => togglePause(true)); fullButton.addEventListener('click', toggleFullscreen);
    restart.addEventListener('click', start); musicButton.addEventListener('click', () => { musicOn = !musicOn; musicButton.textContent = `Musik: ${musicOn ? 'Nyala' : 'Mati'}`; });
    tutorialNext?.addEventListener('click', () => tutorial.classList.add('hidden')); tutorialSkip?.addEventListener('click', () => tutorial.classList.add('hidden'));
    musicRange?.addEventListener('input', () => { musicLabel.textContent = `${musicRange.value}%`; }); sfxRange?.addEventListener('input', () => { sfxLabel.textContent = `${sfxRange.value}%`; });
    document.addEventListener('visibilitychange', () => { if (document.hidden && world.started && !world.paused) togglePause(); });
    setStatus('Tekan Jelajah, lalu ikuti penanda kristal cyan.');
    draw(); syncHud();
}
