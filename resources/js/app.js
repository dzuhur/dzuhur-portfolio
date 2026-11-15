import { mountWorldGame } from './world-game';

const menuToggle = document.querySelector('[data-menu-toggle]');
const mobileMenu = document.querySelector('[data-menu]');

if (menuToggle && mobileMenu) {
    const setMenu = (open) => {
    menuToggle.setAttribute('aria-expanded', String(open));
    mobileMenu.classList.toggle('hidden', !open);

    mobileMenu.getAnimations().forEach((animation) => {
        animation.cancel();
    });

    if (
        open &&
        !window.matchMedia('(prefers-reduced-motion: reduce)').matches
    ) {
        mobileMenu.animate(
            [
                { opacity: 0, transform: 'translateY(-12px)' },
                { opacity: 1, transform: 'translateY(0)' }
            ],
            {
                duration: 250,
                easing: 'ease-out'
            }
        );
    }
};

    menuToggle.addEventListener('click', () => {
        const isOpen = menuToggle.getAttribute('aria-expanded') === 'true';
        setMenu(!isOpen);
    });

    mobileMenu.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setMenu(false));
    });
}

const contactForm = document.querySelector('[data-contact-form]');

if (contactForm) {
    contactForm.addEventListener('submit', () => {
        const button = contactForm.querySelector('[data-submit-button]');

        if (button) {
            button.disabled = true;
            button.textContent = 'Sending…';
        }
    });
}

document.querySelectorAll('form[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (! window.confirm(form.dataset.confirm)) {
            event.preventDefault();
        }
    });
});

const gameBoard = document.querySelector('[data-game-board]');

if (gameBoard?.hasAttribute('data-game-world3d')) mountWorldGame(gameBoard);

if (gameBoard && !gameBoard.hasAttribute('data-game-world3d')) {
    const gameShell = document.querySelector('[data-game-shell]');
    const player = gameBoard.querySelector('[data-game-player]');
    const scoreDisplay = document.querySelector('[data-game-score]');
    const timeDisplay = document.querySelector('[data-game-time]');
    const levelDisplay = document.querySelector('[data-game-level]');
    const hpDisplay = document.querySelector('[data-game-hp]');
    const powerDisplay = document.querySelector('[data-game-power]');
    const bestDisplay = document.querySelector('[data-game-best]');
    const statusDisplay = document.querySelector('[data-game-status]');
    const actionButton = document.querySelector('[data-game-action]');
    const musicButton = document.querySelector('[data-game-music]');
    const dashButton = document.querySelector('[data-game-dash-action]');
    const comboDisplay = document.querySelector('[data-game-combo]');
    const missionDisplay = document.querySelector('[data-game-mission]');
    const dashDisplay = document.querySelector('[data-game-dash]');
    const overdriveButton = document.querySelector('[data-game-overdrive-action]');
    const overdriveBar = document.querySelector('[data-game-overdrive-bar]');
    const overdriveFill = document.querySelector('[data-game-overdrive-fill]');
    const overdriveLabel = document.querySelector('[data-game-overdrive-label]');
    const worldDisplay = document.querySelector('[data-game-world]');
    const worldMechanicDisplay = document.querySelector('[data-game-world-mechanic]');
    const pauseButton = document.querySelector('[data-game-pause]');
    const fullscreenButton = document.querySelector('[data-game-fullscreen]');
    const pauseOverlay = document.querySelector('[data-game-pause-overlay]');
    const resumeButton = document.querySelector('[data-game-resume]');
    const summaryOverlay = document.querySelector('[data-game-summary-overlay]');
    const summaryStats = document.querySelector('[data-game-summary-stats]');
    const achievementsDisplay = document.querySelector('[data-game-achievements]');
    const progressDisplay = document.querySelector('[data-game-progress]');
    const restartButton = document.querySelector('[data-game-restart]');
    const tutorialOverlay = document.querySelector('[data-game-tutorial-overlay]');
    const tutorialStepDisplay = document.querySelector('[data-game-tutorial-step]');
    const tutorialTitle = document.querySelector('[data-game-tutorial-title]');
    const tutorialCopy = document.querySelector('[data-game-tutorial-copy]');
    const tutorialNext = document.querySelector('[data-game-tutorial-next]');
    const tutorialSkip = document.querySelector('[data-game-tutorial-skip]');
    const musicVolumeInput = document.querySelector('[data-game-music-volume]');
    const sfxVolumeInput = document.querySelector('[data-game-sfx-volume]');
    const musicVolumeLabel = document.querySelector('[data-game-music-value]');
    const sfxVolumeLabel = document.querySelector('[data-game-sfx-value]');
    const duelCallout = document.querySelector('[data-game-duel-callout]');
    const duelCountDisplay = document.querySelector('[data-game-duel-count]');
    const duelInstructionDisplay = document.querySelector('[data-game-duel-instruction]');
    const duelHintDisplay = document.querySelector('[data-game-duel-hint]');
    const duelTimerFill = document.querySelector('[data-game-duel-timer]');
    const bestKey = 'portfolio-geometry-runner-best';
    const progressKey = 'portfolio-geometry-runner-progress';
    const tutorialKey = 'portfolio-geometry-runner-tutorial';
    let score = 0;
    let bonusScore = 0;
    const maxHp = 3;
    let hp = maxHp;
    let shieldCharges = 0;
    let invulnerableUntil = 0;
    let dashUntil = 0;
    let dashStartedAt = 0;
    let dashCooldownUntil = 0;
    let overdriveCharge = 0;
    let overdriveUntil = 0;
    let overdriveAnimation = null;
    let combo = 1;
    let comboExpires = 0;
    let missionTarget = 3;
    let missionProgress = 0;
    let missionReward = 250;
    let playing = false;
    let gameOver = false;
    let paused = false;
    let animationFrame = null;
    let lastFrame = 0;
    let elapsed = 0;
    let spawnIn = 1.8;
    let speed = 290;
    let difficultyLevel = 0;
    let waveRemaining = 0;
    let nextWindAt = 6;
    let windUntil = 0;
    let windDirection = 1;
    let duelActive = false;
    let duelAttacks = 0;
    let duelSuccesses = 0;
    let duelExpected = null;
    let duelDeadline = 0;
    let duelNextAt = 0;
    let nextDuelAt = 24;
    let duelist = null;
    let scoredTime = 0;
    const scoreStep = 300;
    let jumpY = 0;
    let jumpVelocity = 0;
    let jumpHeld = false;
    let jumpHoldTime = 0;
    let jumpRotation = 0;
    let shapeScaleX = 1;
    let shapeScaleY = 1;
    let landingUntil = 0;
    let jumpStartUntil = 0;
    const gravity = 1800;
    const jumpBoost = 1050;
    const maxJumpHold = 0.2;
    const obstacles = [];
    const pickups = [];
    let musicNotes = [220, 277, 330, 277, 196, 247, 294, 247];
    const worlds = [
        {
            name: 'NEON CITY', mechanic: 'Zona dasar · ritme seimbang', accent: '#22d3ee', gravity: 1, speed: 1,
            background: 'radial-gradient(ellipse at 78% 20%, rgba(34,211,238,.18), transparent 34%), linear-gradient(180deg,#07111f 0%,#101327 60%,#171126 100%)', notes: [220, 277, 330, 277, 196, 247, 294, 247],
        },
        {
            name: 'MOONFALL', mechanic: 'Gravitasi rendah · melayang lebih lama', accent: '#a78bfa', gravity: .72, speed: 1,
            background: 'radial-gradient(circle at 78% 23%, rgba(221,214,254,.8) 0 2%, rgba(167,139,250,.3) 3%, transparent 18%), linear-gradient(180deg,#11102d 0%,#1a1740 58%,#101a35 100%)', notes: [174, 220, 261, 220, 164, 196, 233, 196],
        },
        {
            name: 'TEMPEST', mechanic: 'Angin berkala · lompatan bisa terdorong', accent: '#38bdf8', gravity: .95, speed: 1, wind: true,
            background: 'radial-gradient(ellipse at 25% 25%, rgba(56,189,248,.2), transparent 38%), linear-gradient(180deg,#071522 0%,#123047 56%,#101b2b 100%)', notes: [196, 233, 294, 349, 294, 233, 175, 233],
        },
        {
            name: 'SOLAR FORGE', mechanic: 'Panas ekstrem · rintangan lebih cepat', accent: '#fb923c', gravity: 1.08, speed: 1.08,
            background: 'radial-gradient(ellipse at 72% 22%, rgba(251,146,60,.32), transparent 30%), linear-gradient(180deg,#261019 0%,#421b20 58%,#1e111a 100%)', notes: [164, 207, 246, 311, 246, 207, 155, 207],
        },
        {
            name: 'THE VOID', mechanic: 'Gravitasi berdenyut · baca ritme arena', accent: '#e879f9', gravity: .9, speed: .98, pulse: true,
            background: 'radial-gradient(circle at 18% 22%, rgba(255,255,255,.8) 0 1px, transparent 2px), radial-gradient(circle at 68% 36%, rgba(232,121,249,.65) 0 1px, transparent 2px), radial-gradient(ellipse at 55% 10%, rgba(126,34,206,.3), transparent 45%), linear-gradient(180deg,#100719 0%,#21102d 60%,#110d1c 100%)', notes: [130, 196, 233, 261, 233, 174, 207, 155],
        },
    ];
    let audioContext = null;
    let musicTimer = null;
    let musicStep = 0;
    let musicEnabled = true;
    let musicVolume = 0.35;
    let sfxVolume = 0.7;
    let tutorialStep = 0;
    let tutorialCompleted = false;
    let maxCombo = 1;
    let missionsCompleted = 0;
    let runDuelWins = 0;
    let persistentProgress = { runs: 0, duelWins: 0, highestLevel: 1, achievements: {} };

    try {
        const savedMusicVolume = localStorage.getItem(`${progressKey}-music`);
        const savedSfxVolume = localStorage.getItem(`${progressKey}-sfx`);
        musicVolume = savedMusicVolume === null ? 0.35 : Math.min(1, Math.max(0, Number(savedMusicVolume)));
        sfxVolume = savedSfxVolume === null ? 0.7 : Math.min(1, Math.max(0, Number(savedSfxVolume)));
        persistentProgress = { ...persistentProgress, ...JSON.parse(localStorage.getItem(progressKey) || '{}') };
        persistentProgress.achievements ||= {};
        tutorialCompleted = localStorage.getItem(tutorialKey) === 'done';
    } catch {
        // Audio settings and progress fall back to defaults if storage is unavailable.
    }

    const playTone = (frequency, duration, volume, type = 'sine', channel = 'sfx') => {
        if (!audioContext) return;

        const oscillator = audioContext.createOscillator();
        const gain = audioContext.createGain();
        const now = audioContext.currentTime;
        oscillator.type = type;
        oscillator.frequency.setValueAtTime(frequency, now);
        gain.gain.setValueAtTime(0.0001, now);
        gain.gain.exponentialRampToValueAtTime(volume * (channel === 'music' ? musicVolume : sfxVolume), now + 0.02);
        gain.gain.exponentialRampToValueAtTime(0.0001, now + duration);
        oscillator.connect(gain);
        gain.connect(audioContext.destination);
        oscillator.start(now);
        oscillator.stop(now + duration + 0.03);
    };

    const playNoise = (duration, volume, filterType, startFrequency, endFrequency) => {
        if (!audioContext) return;

        const now = audioContext.currentTime;
        const sampleRate = audioContext.sampleRate;
        const buffer = audioContext.createBuffer(1, Math.ceil(sampleRate * duration), sampleRate);
        const samples = buffer.getChannelData(0);
        for (let index = 0; index < samples.length; index += 1) {
            const fade = 1 - index / samples.length;
            samples[index] = (Math.random() * 2 - 1) * fade * fade;
        }

        const source = audioContext.createBufferSource();
        const filter = audioContext.createBiquadFilter();
        const gain = audioContext.createGain();
        source.buffer = buffer;
        filter.type = filterType;
        filter.frequency.setValueAtTime(startFrequency, now);
        filter.frequency.exponentialRampToValueAtTime(Math.max(30, endFrequency), now + duration);
        gain.gain.setValueAtTime(0.0001, now);
        gain.gain.exponentialRampToValueAtTime(volume * sfxVolume, now + 0.012);
        gain.gain.exponentialRampToValueAtTime(0.0001, now + duration);
        source.connect(filter);
        filter.connect(gain);
        gain.connect(audioContext.destination);
        source.start(now);
        source.stop(now + duration + 0.02);
    };

    const pulseBoard = (color = '#67e8f9', duration = 320) => {
        if (typeof gameBoard.animate === 'function') {
            gameBoard.animate(
                [
                    { filter: 'brightness(1) saturate(1)', boxShadow: 'inset 0 0 0 0 transparent' },
                    { filter: 'brightness(1.65) saturate(1.8)', boxShadow: `inset 0 0 45px ${color}88` },
                    { filter: 'brightness(1) saturate(1)', boxShadow: 'inset 0 0 0 0 transparent' },
                ],
                { duration, easing: 'ease-out' },
            );
        }
    };

    const burst = (x, y, color = '#67e8f9', count = 12) => {
        for (let index = 0; index < count; index += 1) {
            const particle = document.createElement('i');
            const angle = (Math.PI * 2 * index) / count;
            const distance = 24 + Math.random() * 42;
            particle.setAttribute('aria-hidden', 'true');
            Object.assign(particle.style, {
                position: 'absolute', left: `${x}px`, top: `${y}px`, width: '6px', height: '6px',
                borderRadius: '50%', background: color, boxShadow: `0 0 12px ${color}`,
                pointerEvents: 'none', zIndex: '5',
            });
            gameBoard.appendChild(particle);
            const animation = particle.animate?.([
                { transform: 'translate(-50%, -50%) scale(1)', opacity: 1 },
                { transform: `translate(calc(-50% + ${Math.cos(angle) * distance}px), calc(-50% + ${Math.sin(angle) * distance}px)) scale(0)`, opacity: 0 },
            ], { duration: 460, easing: 'cubic-bezier(.15,.8,.3,1)' });
            if (animation) animation.onfinish = () => particle.remove();
            window.setTimeout(() => particle.remove(), 500);
        }
    };

    const screenShake = (amount = 5, duration = 240) => {
        if (!gameBoard.animate) return;
        gameBoard.animate([
            { transform: 'translateX(0)' },
            { transform: `translateX(${-amount}px)` },
            { transform: `translateX(${amount}px)` },
            { transform: `translateX(${-amount / 2}px)` },
            { transform: 'translateX(0)' },
        ], { duration, easing: 'ease-out' });
    };

    const stopMusic = () => {
        window.clearInterval(musicTimer);
        musicTimer = null;
    };

    const startMusic = () => {
        if (!audioContext || musicTimer || !musicEnabled) return;
        musicTimer = window.setInterval(() => {
            const note = musicNotes[musicStep % musicNotes.length];
            playTone(note, 0.24, 0.06, 'triangle', 'music');
            if (musicStep % 4 === 0) playTone(note / 2, 0.38, 0.035, 'sine', 'music');
            musicStep += 1;
        }, 320);
    };

    const enableAudio = () => {
        try {
            const AudioContextClass = window.AudioContext || window.webkitAudioContext;
            if (!AudioContextClass) return;
            audioContext ??= new AudioContextClass();
            if (audioContext.state === 'suspended') audioContext.resume().catch(() => {});
            startMusic();
        } catch {
            // Keep the game playable if browser audio is unavailable.
        }
    };

    try {
        bestDisplay.textContent = `Terbaik: ${Number(localStorage.getItem(bestKey)) || 0}`;
    } catch {
        bestDisplay.textContent = 'Terbaik: 0';
    }

    const updatePlayer = () => {
        player.style.transform = `translateY(${-jumpY}px) rotate(${jumpRotation}deg) scale(${shapeScaleX}, ${shapeScaleY})`;
    };

    const landingEffect = () => {
        const centerX = player.offsetLeft + player.offsetWidth / 2;
        const floorY = gameBoard.clientHeight - 31;
        const ring = document.createElement('i');
        Object.assign(ring.style, {
            position: 'absolute', left: `${centerX}px`, top: `${floorY}px`, width: '18px', height: '8px',
            border: '2px solid rgba(251,146,60,.9)', borderRadius: '50%', transform: 'translate(-50%,-50%)',
            boxShadow: '0 0 12px rgba(251,146,60,.8)', pointerEvents: 'none', zIndex: '1',
        });
        gameBoard.appendChild(ring);
        const ringAnimation = ring.animate?.([
            { opacity: .9, transform: 'translate(-50%,-50%) scale(.5, .5)' },
            { opacity: 0, transform: 'translate(-50%,-50%) scale(3.8, 1.5)' },
        ], { duration: 300, easing: 'ease-out' });
        if (ringAnimation) ringAnimation.onfinish = () => ring.remove();
        window.setTimeout(() => ring.remove(), 320);
        burst(centerX, floorY, '#fb923c', 6);
        playNoise(0.18, 0.12, 'lowpass', 220, 65);
        playTone(82, 0.16, 0.055, 'sine');
    };

    const updateHud = () => {
        hpDisplay.textContent = `${'♥'.repeat(hp)}${'♡'.repeat(maxHp - hp)}`;
        hpDisplay.setAttribute('aria-label', `${hp} dari ${maxHp} HP`);
        levelDisplay.textContent = String(difficultyLevel + 1);
        powerDisplay.textContent = `Perisai: ${shieldCharges}`;
        comboDisplay.textContent = `×${combo}`;
        missionDisplay.textContent = missionProgress >= missionTarget
            ? 'Selesai!'
            : `Ambil ${missionTarget - missionProgress} pecahan`;
        dashDisplay.textContent = dashCooldownUntil <= elapsed ? 'Siap' : `${Math.ceil(dashCooldownUntil - elapsed)} dtk`;
        overdriveFill.style.width = `${overdriveCharge}%`;
        overdriveBar.setAttribute('aria-valuenow', String(overdriveCharge));
        overdriveButton.disabled = !playing || overdriveCharge < 100 || overdriveUntil > elapsed;
        overdriveLabel.textContent = overdriveUntil > elapsed
            ? `AKTIF · ${Math.max(0, overdriveUntil - elapsed).toFixed(1)} dtk`
            : `Energi ${overdriveCharge}%`;
    };

    const createDuelist = () => {
        if (duelist) return duelist;
        duelist = document.createElement('div');
        duelist.setAttribute('aria-hidden', 'true');
        Object.assign(duelist.style, {
            position: 'absolute', right: '18%', bottom: '27px', width: '48px', height: '83px',
            zIndex: '2', filter: 'drop-shadow(0 0 16px rgba(248,113,113,.75))',
        });
        const parts = [
            ['top:2px;left:15px;width:20px;height:20px;border-radius:50%;background:#f3c6a5;border:2px solid #fff'],
            ['top:24px;left:9px;width:32px;height:32px;clip-path:polygon(18% 0,82% 0,100% 100%,0 100%);background:linear-gradient(135deg,#ef4444,#7f1d1d);border:1px solid #fecaca'],
            ['top:30px;left:0;width:15px;height:9px;border-radius:99px;background:#f87171;transform:rotate(-24deg)'],
            ['top:30px;right:0;width:15px;height:9px;border-radius:99px;background:#f87171;transform:rotate(24deg)'],
            ['top:52px;left:11px;width:10px;height:28px;border-radius:8px;background:#292133;transform:rotate(8deg)'],
            ['top:52px;right:11px;width:10px;height:28px;border-radius:8px;background:#292133;transform:rotate(-8deg)'],
        ];
        parts.forEach((styles) => {
            const part = document.createElement('i');
            part.style.cssText = `position:absolute;${styles[0]}`;
            duelist.appendChild(part);
        });
        gameBoard.appendChild(duelist);
        duelist.animate?.([{ transform: 'translateY(0)' }, { transform: 'translateY(-4px)' }, { transform: 'translateY(0)' }], { duration: 900, iterations: Infinity, easing: 'ease-in-out' });
        return duelist;
    };

    const startDuel = () => {
        duelActive = true;
        duelAttacks = 0;
        duelSuccesses = 0;
        duelExpected = null;
        duelNextAt = elapsed + 1.1;
        obstacles.forEach((obstacle) => obstacle.remove());
        obstacles.length = 0;
        pickups.forEach((pickup) => pickup.remove());
        pickups.length = 0;
        createDuelist();
        duelCallout?.classList.remove('hidden');
        if (duelCountDisplay) duelCountDisplay.textContent = 'DUEL DIMULAI';
        if (duelInstructionDisplay) duelInstructionDisplay.textContent = 'BACA POLA';
        if (duelHintDisplay) duelHintDisplay.textContent = 'Lompati sapuan rendah · Dash hindari pukulan atas';
        if (duelTimerFill) duelTimerFill.style.transform = 'scaleX(0)';
        gameBoard.style.backgroundImage = 'radial-gradient(ellipse at 76% 42%, rgba(248,113,113,.28), transparent 34%), linear-gradient(180deg,#1a101b 0%,#27151d 65%,#111018 100%)';
        gameBoard.style.borderColor = '#fb7185';
        statusDisplay.textContent = '⚠ TANTANGAN DUEL! Baca pola lawan: lompat atau Dash.';
        pulseBoard('#fb7185', 620);
        screenShake(7, 360);
        burst(gameBoard.clientWidth * .72, gameBoard.clientHeight * .55, '#fb7185', 24);
        playTone(165, 0.35, 0.07, 'sawtooth');
        playNoise(.45, .05, 'lowpass', 500, 100);
    };

    const resolveDuelAction = (action) => {
        if (!duelActive || !duelExpected) return false;
        if (action === duelExpected) {
            duelSuccesses += 1;
            duelExpected = null;
            duelNextAt = elapsed + 0.52;
            bonusScore += 75;
            score += 75;
            scoreDisplay.textContent = score;
            statusDisplay.textContent = `COUNTER! ${duelSuccesses}/3 serangan berhasil dibaca.`;
            if (duelInstructionDisplay) duelInstructionDisplay.textContent = 'COUNTER!';
            if (duelHintDisplay) duelHintDisplay.textContent = 'Tepat! Bersiap untuk serangan berikutnya.';
            if (duelTimerFill) duelTimerFill.style.transform = 'scaleX(0)';
            duelist?.animate?.([{ transform: 'translateX(0) rotate(0)' }, { transform: 'translateX(26px) rotate(18deg)' }, { transform: 'translateX(0) rotate(0)' }], { duration: 360 });
            burst(duelist?.offsetLeft + 24 || gameBoard.clientWidth * .72, gameBoard.clientHeight - 70, '#fef08a', 14);
            playTone(880, .12, .055, 'square');
            playTone(1180, .2, .04, 'triangle');
            pulseBoard('#fef08a', 280);
            return true;
        }

        duelExpected = null;
        hp = Math.max(0, hp - 1);
        combo = 1;
        invulnerableUntil = elapsed + 1;
        duelNextAt = elapsed + 0.75;
        updateHud();
        statusDisplay.textContent = `Serangan kena! HP tersisa ${hp}. Bersiap untuk pola berikutnya.`;
        if (duelInstructionDisplay) duelInstructionDisplay.textContent = 'TERKENA!';
        if (duelHintDisplay) duelHintDisplay.textContent = `HP tersisa ${hp} · Serangan berikutnya segera datang`;
        if (duelTimerFill) duelTimerFill.style.transform = 'scaleX(0)';
        pulseBoard('#fb7185', 420);
        screenShake(9, 300);
        burst(player.offsetLeft + player.offsetWidth / 2, gameBoard.clientHeight - 65, '#fb7185', 18);
        playNoise(.22, .15, 'lowpass', 280, 55);
        playTone(72, .2, .06, 'sine');
        if (hp <= 0) finishGame();
        return false;
    };

    const finishDuel = () => {
        duelActive = false;
        duelExpected = null;
        duelCallout?.classList.add('hidden');
        duelist?.remove();
        duelist = null;
        applyWorld();
        const reward = duelSuccesses >= 2 ? 400 : 150;
        bonusScore += reward;
        score += reward;
        scoreDisplay.textContent = score;
        if (duelSuccesses >= 2) {
            runDuelWins += 1;
            persistentProgress.duelWins = (persistentProgress.duelWins || 0) + 1;
            savePersistentProgress();
            shieldCharges = Math.min(shieldCharges + 1, 2);
            overdriveCharge = Math.min(100, overdriveCharge + 35);
            statusDisplay.textContent = `DUEL DIMENANGKAN! +${reward} poin, 1 perisai, energi +35%.`;
        } else {
            statusDisplay.textContent = `Lawan lolos, tapi kamu bertahan. Hadiah +${reward} poin.`;
        }
        nextDuelAt = elapsed + 30 + Math.random() * 16;
        spawnIn = 1.2;
        updateHud();
        pulseBoard('#fef08a', 520);
        burst(gameBoard.clientWidth * .55, gameBoard.clientHeight * .48, '#fef08a', 26);
        playTone(523, .18, .05, 'triangle');
        window.setTimeout(() => playTone(784, .32, .045, 'triangle'), 110);
    };

    const getWorld = () => worlds[difficultyLevel % worlds.length];

    const applyWorld = () => {
        const world = getWorld();
        gameBoard.style.backgroundColor = '#090b18';
        gameBoard.style.backgroundImage = world.background;
        gameBoard.style.borderColor = world.accent;
        worldDisplay.textContent = world.name;
        worldDisplay.style.color = world.accent;
        worldMechanicDisplay.textContent = world.mechanic;
        musicNotes = world.notes;
        musicStep = 0;
    };

    const tutorialSteps = [
        ['Lompatan', 'Tekan Spasi, ↑, atau sentuh arena. Tahan sebentar untuk melompat lebih tinggi.'],
        ['Dash', 'Tekan Shift atau tombol Dash untuk menerobos rintangan. Dash juga berguna untuk serangan duel.'],
        ['Overdrive', 'Kumpulkan energi dari pickup dan Dash. Saat penuh, tekan X untuk memperlambat dunia dan menggandakan poin pickup.'],
        ['Baca lawan', 'Duel memberi instruksi SAPUAN = lompat atau PUKULAN = Dash. Balas sebelum telegraph berakhir.'],
    ];

    const showTutorial = () => {
        tutorialStep = 0;
        tutorialOverlay.classList.remove('hidden');
        tutorialOverlay.classList.add('flex');
        tutorialStepDisplay.textContent = `PELATIHAN · 1/${tutorialSteps.length}`;
        tutorialTitle.textContent = tutorialSteps[0][0];
        tutorialCopy.textContent = tutorialSteps[0][1];
        gameBoard.focus({ preventScroll: true });
    };

    const finishTutorial = (startAfter = true) => {
        tutorialOverlay.classList.add('hidden');
        tutorialOverlay.classList.remove('flex');
        tutorialCompleted = true;
        try { localStorage.setItem(tutorialKey, 'done'); } catch { /* Tutorial can still be skipped for this session. */ }
        if (startAfter) jumpOrStart();
    };

    const advanceTutorial = () => {
        tutorialStep += 1;
        if (tutorialStep >= tutorialSteps.length) {
            finishTutorial();
            return;
        }
        tutorialStepDisplay.textContent = `PELATIHAN · ${tutorialStep + 1}/${tutorialSteps.length}`;
        tutorialTitle.textContent = tutorialSteps[tutorialStep][0];
        tutorialCopy.textContent = tutorialSteps[tutorialStep][1];
        tutorialNext.textContent = tutorialStep === tutorialSteps.length - 1 ? 'Mulai game' : 'Lanjut';
    };

    const togglePause = (forceResume = false) => {
        if (!playing) return;
        if (paused || forceResume) {
            paused = false;
            pauseOverlay.classList.add('hidden');
            pauseOverlay.classList.remove('flex');
            pauseButton.textContent = 'Jeda (P)';
            lastFrame = performance.now();
            enableAudio();
            animationFrame = window.requestAnimationFrame(frame);
            return;
        }
        paused = true;
        window.cancelAnimationFrame(animationFrame);
        stopMusic();
        pauseOverlay.classList.remove('hidden');
        pauseOverlay.classList.add('flex');
        pauseButton.textContent = 'Lanjutkan (P)';
    };

    const toggleFullscreen = async () => {
        try {
            if (document.fullscreenElement === gameShell) await document.exitFullscreen();
            else await gameShell.requestFullscreen();
        } catch {
            statusDisplay.textContent = 'Fullscreen tidak diizinkan browser untuk halaman ini.';
        }
    };

    document.addEventListener('fullscreenchange', () => {
        const isFullscreen = document.fullscreenElement === gameShell;
        fullscreenButton.textContent = isFullscreen ? 'Keluar Fullscreen (F)' : 'Fullscreen (F)';
        fullscreenButton.setAttribute('aria-pressed', String(isFullscreen));
    });

    const savePersistentProgress = () => {
        try { localStorage.setItem(progressKey, JSON.stringify(persistentProgress)); } catch { /* Keep the run playable without storage. */ }
    };

    const showSummary = () => {
        const unlock = (key) => { persistentProgress.achievements[key] = true; };
        if (score > 0) unlock('first-run');
        if (difficultyLevel >= 4) unlock('level-five');
        if (maxCombo >= 5) unlock('combo-five');
        if (runDuelWins > 0) unlock('duel-winner');
        if (missionsCompleted >= 3) unlock('mission-master');
        persistentProgress.highestLevel = Math.max(persistentProgress.highestLevel || 1, difficultyLevel + 1);
        savePersistentProgress();

        const stats = [
            ['Skor akhir', score], ['Waktu bertahan', formatTime(scoredTime)],
            ['Level tertinggi', difficultyLevel + 1], ['Combo terbaik', `×${maxCombo}`],
            ['Duel dimenangkan', runDuelWins], ['Misi selesai', missionsCompleted],
        ];
        summaryStats.innerHTML = stats.map(([label, value]) => `<p class="rounded-lg border border-white/10 px-3 py-2 text-neutral-300">${label}<strong class="mt-1 block text-lg text-white">${value}</strong></p>`).join('');
        const achievements = [
            ['first-run', 'Langkah Pertama'], ['level-five', 'Penjelajah Level 5'],
            ['combo-five', 'Combo ×5'], ['duel-winner', 'Juara Duel'], ['mission-master', 'Master Misi'],
        ];
        achievementsDisplay.innerHTML = achievements.map(([key, label]) => `<span class="rounded-full border px-3 py-1 ${persistentProgress.achievements[key] ? 'border-amber-300/50 bg-amber-300/10 text-amber-200' : 'border-white/10 text-neutral-500'}">${persistentProgress.achievements[key] ? '★' : '◇'} ${label}</span>`).join('');
        progressDisplay.textContent = `Progres tersimpan · ${persistentProgress.runs || 0} run · rekor Level ${persistentProgress.highestLevel || 1} · ${persistentProgress.duelWins || 0} duel dimenangkan.`;
        summaryOverlay.classList.remove('hidden');
        summaryOverlay.classList.add('flex');
    };

    const windEffect = (direction) => {
        for (let index = 0; index < 7; index += 1) {
            const streak = document.createElement('i');
            const y = 38 + Math.random() * Math.max(40, gameBoard.clientHeight - 115);
            Object.assign(streak.style, {
                position: 'absolute', top: `${y}px`, left: direction > 0 ? '-90px' : `${gameBoard.clientWidth + 20}px`,
                width: `${45 + Math.random() * 80}px`, height: '2px', borderRadius: '99px',
                background: 'linear-gradient(90deg, transparent, rgba(125,211,252,.9), transparent)',
                boxShadow: '0 0 8px rgba(56,189,248,.8)', pointerEvents: 'none', zIndex: '2',
            });
            gameBoard.appendChild(streak);
            const animation = streak.animate?.([
                { transform: 'translateX(0)', opacity: 0 },
                { opacity: .9, offset: .2 },
                { transform: `translateX(${direction > 0 ? gameBoard.clientWidth + 220 : -gameBoard.clientWidth - 220}px)`, opacity: 0 },
            ], { duration: 620 + Math.random() * 400, easing: 'linear' });
            if (animation) animation.onfinish = () => streak.remove();
            window.setTimeout(() => streak.remove(), 1100);
        }
    };

    applyWorld();
    updateHud();

    const finishGame = () => {
        playing = false;
        gameOver = true;
        paused = false;
        pauseButton.disabled = true;
        pauseButton.textContent = 'Jeda (P)';
        pauseOverlay.classList.add('hidden');
        pauseOverlay.classList.remove('flex');
        if (duelActive) applyWorld();
        duelActive = false;
        duelExpected = null;
        duelCallout?.classList.add('hidden');
        duelist?.remove();
        duelist = null;
        window.cancelAnimationFrame(animationFrame);
        stopMusic();
        playTone(150, 0.32, 0.045, 'sawtooth');
        if (typeof gameBoard.animate === 'function') {
            gameBoard.animate(
                [{ transform: 'translateX(0)' }, { transform: 'translateX(-7px)' }, { transform: 'translateX(7px)' }, { transform: 'translateX(0)' }],
                { duration: 220 },
            );
        }
        actionButton.textContent = 'Coba Lagi';
        statusDisplay.textContent = `Game over di Level ${difficultyLevel + 1}! Skor ${score} · Combo terbaik ×${combo}. Tekan Spasi atau ↑ untuk mencoba lagi.`;

        let best = 0;
        try {
            best = Number(localStorage.getItem(bestKey)) || 0;
            if (score > best) {
                best = score;
                localStorage.setItem(bestKey, String(best));
            }
        } catch {
            // The game still works when browser storage is unavailable.
        }
        bestDisplay.textContent = `Terbaik: ${best}`;
        showSummary();
    };

    const useDash = () => {
        if (paused) return;
        if (duelActive && duelExpected) {
            if (!resolveDuelAction('dash')) return;
            dashStartedAt = elapsed;
            dashUntil = elapsed + 0.62;
            invulnerableUntil = Math.max(invulnerableUntil, dashUntil);
            return;
        }
        if (!playing || dashCooldownUntil > elapsed) return;
        dashStartedAt = elapsed;
        dashUntil = elapsed + 0.62;
        dashCooldownUntil = elapsed + 5.5;
        invulnerableUntil = Math.max(invulnerableUntil, dashUntil);
        statusDisplay.textContent = '⚡ PHASE DASH! Tembus rintangan!';
        player.animate?.([
            { transform: `translateY(${-jumpY}px) rotate(${jumpRotation}deg) scale(1, 1)`, filter: 'brightness(1)' },
            { transform: `translateY(${-jumpY}px) rotate(${jumpRotation + 90}deg) scale(1.45, .68)`, filter: 'brightness(2)' },
            { transform: `translateY(${-jumpY}px) rotate(${jumpRotation + 180}deg) scale(.82, 1.18)`, filter: 'brightness(1.5)' },
        ], { duration: 360, easing: 'cubic-bezier(.2,.8,.2,1)' });
        dashButton.animate?.([
            { transform: 'scale(1)', boxShadow: '0 0 0 transparent' },
            { transform: 'scale(1.12)', boxShadow: '0 0 28px #22d3ee' },
            { transform: 'scale(1)', boxShadow: '0 0 0 transparent' },
        ], { duration: 420 });
        burst(player.offsetLeft + player.offsetWidth / 2, gameBoard.clientHeight - (30 + jumpY + player.offsetHeight / 2), '#22d3ee', 22);
        playTone(180, 0.1, 0.07, 'sawtooth');
        playTone(520, 0.24, 0.055, 'triangle');
        pulseBoard('#22d3ee', 480);
        screenShake(4, 200);
        updateHud();
    };

    const chargeOverdrive = (amount) => {
        if (overdriveUntil <= elapsed) overdriveCharge = Math.min(100, overdriveCharge + amount);
    };

    const activateOverdrive = () => {
        if (!playing || paused || overdriveCharge < 100 || overdriveUntil > elapsed) return;
        overdriveCharge = 0;
        overdriveUntil = elapsed + 5;
        invulnerableUntil = Math.max(invulnerableUntil, overdriveUntil);
        statusDisplay.textContent = '✦ OVERDRIVE! Waktu melambat, pickup bernilai ×2, kebal aktif!';
        overdriveAnimation?.cancel();
        overdriveAnimation = gameBoard.animate?.([
            { filter: 'hue-rotate(0deg) brightness(1)' },
            { filter: 'hue-rotate(100deg) brightness(1.7)' },
            { filter: 'hue-rotate(240deg) brightness(1.25)' },
        ], { duration: 900, iterations: 5 });
        if (overdriveAnimation) overdriveAnimation.onfinish = () => { overdriveAnimation = null; };
        burst(gameBoard.clientWidth / 2, gameBoard.clientHeight / 2, '#e879f9', 30);
        pulseBoard('#d946ef', 650);
        screenShake(6, 350);
        playTone(220, 0.24, 0.06, 'sawtooth');
        window.setTimeout(() => playTone(440, 0.34, 0.05, 'triangle'), 100);
        window.setTimeout(() => playTone(880, 0.45, 0.035, 'sine'), 220);
        updateHud();
    };

    const createObstacle = () => {
        const obstacle = document.createElement('span');
        const roll = Math.random();
        const scale = Math.min(difficultyLevel * 3, 27);
        let width;
        let height;
        let bottom = 25;
        let shape;
        let color = '#e8590c';

        if (roll < 0.25) {
            width = 28 + Math.round(Math.random() * 12);
            height = 34 + Math.round(Math.random() * 20) + scale;
            shape = 'polygon(50% 0, 100% 100%, 0 100%)';
        } else if (roll < 0.42) {
            width = 54 + Math.round(Math.random() * 10);
            height = 38 + Math.round(Math.random() * 16) + scale;
            shape = 'polygon(0 100%, 22% 0, 45% 100%, 52% 100%, 76% 0, 100% 100%)';
        } else if (roll < 0.62) {
            width = 30 + Math.round(Math.random() * 16);
            height = 30 + Math.round(Math.random() * 26) + scale;
            shape = 'none';
            color = '#7c3aed';
        } else if (roll < 0.78) {
            width = 22 + Math.round(Math.random() * 10);
            height = 58 + Math.round(Math.random() * 18) + scale;
            shape = 'none';
            color = '#dc2626';
        } else if (roll < 0.91) {
            width = 28;
            height = 28;
            bottom = 65 + Math.round(Math.random() * 18);
            shape = 'circle';
            color = '#0891b2';
        } else {
            width = 58 + Math.round(Math.random() * 22);
            height = 24 + Math.round(Math.random() * 10);
            shape = 'none';
            color = '#ca8a04';
        }

        obstacle.setAttribute('aria-hidden', 'true');
        obstacle.style.position = 'absolute';
        obstacle.style.left = `${gameBoard.clientWidth + 12}px`;
        obstacle.style.bottom = `${bottom}px`;
        obstacle.style.width = `${width}px`;
        obstacle.style.height = `${Math.min(height, 92)}px`;
        obstacle.style.background = color;
        obstacle.style.clipPath = shape;
        if (shape === 'circle') obstacle.style.borderRadius = '50%';
        obstacle.dataset.gameObstacle = '';
        gameBoard.appendChild(obstacle);
        obstacles.push(obstacle);
    };

    const createSignalShard = () => {
        const shard = document.createElement('span');
        shard.setAttribute('aria-hidden', 'true');
        shard.style.position = 'absolute';
        shard.style.left = `${gameBoard.clientWidth + 12}px`;
        shard.style.bottom = `${55 + Math.round(Math.random() * 55)}px`;
        shard.style.width = '22px';
        shard.style.height = '22px';
        shard.style.background = '#22d3ee';
        shard.style.clipPath = 'polygon(50% 0, 61% 35%, 100% 50%, 61% 65%, 50% 100%, 39% 65%, 0 50%, 39% 35%)';
        shard.style.filter = 'drop-shadow(0 0 8px #22d3ee)';
        shard.dataset.gamePickup = '';
        gameBoard.appendChild(shard);
        pickups.push(shard);
    };

    const createPowerUp = () => {
        const powerUp = document.createElement('span');
        const kind = Math.random() < 0.55 ? 'shield' : 'heart';
        powerUp.setAttribute('aria-hidden', 'true');
        powerUp.style.position = 'absolute';
        powerUp.style.left = `${gameBoard.clientWidth + 12}px`;
        powerUp.style.bottom = '65px';
        powerUp.style.width = '30px';
        powerUp.style.height = '30px';
        powerUp.style.display = 'grid';
        powerUp.style.placeItems = 'center';
        powerUp.style.borderRadius = '9px';
        powerUp.style.border = '1px solid rgba(255,255,255,0.8)';
        powerUp.style.color = 'white';
        powerUp.style.fontSize = '17px';
        powerUp.style.fontWeight = '700';
        powerUp.style.background = kind === 'shield' ? '#2563eb' : '#e11d48';
        powerUp.style.boxShadow = `0 0 18px ${kind === 'shield' ? '#3b82f6' : '#fb7185'}`;
        powerUp.textContent = kind === 'shield' ? '⛨' : '+';
        powerUp.dataset.gamePickup = kind;
        gameBoard.appendChild(powerUp);
        pickups.push(powerUp);
    };

    const formatTime = (seconds) => {
        const minutes = Math.floor(seconds / 60).toString().padStart(2, '0');
        const remainder = Math.floor(seconds % 60).toString().padStart(2, '0');
        return `${minutes}:${remainder}`;
    };

    const frame = (timestamp) => {
        if (!playing || paused) return;

        const delta = Math.min((timestamp - lastFrame) / 1000, 0.05);
        lastFrame = timestamp;
        elapsed += delta;
        if (!duelActive) scoredTime += delta;
        if (overdriveUntil <= elapsed) overdriveCharge = Math.min(100, overdriveCharge + delta * 0.8);
        score = Math.floor(scoredTime * 10) + bonusScore;
        scoreDisplay.textContent = score;
        timeDisplay.textContent = formatTime(elapsed);

        const nextDifficultyLevel = Math.floor(score / scoreStep);
        if (nextDifficultyLevel > difficultyLevel) {
            difficultyLevel = nextDifficultyLevel;
            const world = getWorld();
            applyWorld();
            windUntil = 0;
            nextWindAt = elapsed + (world.wind ? 5 : 6);
            player.style.filter = `hue-rotate(${difficultyLevel * 67}deg)`;
            updateHud();
            statusDisplay.textContent = `Level ${difficultyLevel + 1} · ${world.name}! ${world.mechanic}.`;
            pulseBoard(world.accent, 700);
            screenShake(3 + Math.min(difficultyLevel, 5), 320);
            burst(gameBoard.clientWidth / 2, gameBoard.clientHeight / 2, world.accent, 24);
            playTone(440 + difficultyLevel * 55, 0.22, 0.05, 'triangle');
            window.setTimeout(() => playTone(660 + difficultyLevel * 65, 0.28, 0.04, 'triangle'), 100);
        }
        const activeWorld = getWorld();
        if (!duelActive && score >= 300 && elapsed >= nextDuelAt) startDuel();
        if (duelActive) {
            if (duelExpected && elapsed >= duelDeadline) {
                resolveDuelAction('timeout');
            } else if (!duelExpected && elapsed >= duelNextAt) {
                if (duelAttacks >= 3) {
                    finishDuel();
                } else {
                    duelAttacks += 1;
                    // Siklus tetap membuat duel mudah dipelajari: lompat, Dash, lompat.
                    duelExpected = duelAttacks % 2 === 1 ? 'jump' : 'dash';
                    duelDeadline = elapsed + 1.65;
                    if (duelCountDisplay) duelCountDisplay.textContent = `DUEL · ${duelAttacks}/3`;
                    if (duelInstructionDisplay) duelInstructionDisplay.textContent = duelExpected === 'jump' ? 'LOMPAT!' : 'DASH!';
                    if (duelHintDisplay) duelHintDisplay.textContent = duelExpected === 'jump'
                        ? 'SAPUAN RENDAH · Spasi / ↑ / sentuh'
                        : 'PUKULAN ATAS · Shift / tombol Dash';
                    if (duelTimerFill) duelTimerFill.style.transform = 'scaleX(1)';
                    statusDisplay.textContent = duelExpected === 'jump'
                        ? `SERANGAN ${duelAttacks}/3 · SAPUAN RENDAH! LOMPAT SEKARANG!`
                        : `SERANGAN ${duelAttacks}/3 · PUKULAN DATANG! DASH SEKARANG!`;
                    duelist?.animate?.([
                        { transform: 'translateX(0) rotate(0)' },
                        { transform: 'translateX(-24px) rotate(-22deg)' },
                        { transform: 'translateX(0) rotate(0)' },
                    ], { duration: 360, easing: 'ease-in' });
                    playTone(duelExpected === 'jump' ? 260 : 340, .18, .06, 'square');
                    playNoise(.22, .045, 'highpass', 260, 820);
                    pulseBoard('#fda4af', 320);
                }
            }
            if (duelExpected && duelTimerFill) {
                duelTimerFill.style.transform = `scaleX(${Math.max(0, (duelDeadline - elapsed) / 1.65)})`;
            }
        }
        if (activeWorld.wind && elapsed >= nextWindAt) {
            windDirection = Math.random() < 0.5 ? -1 : 1;
            windUntil = elapsed + 1.4;
            nextWindAt = elapsed + 7 + Math.random() * 3;
            statusDisplay.textContent = windDirection > 0 ? 'Angin badai mendorong lompatan ke atas!' : 'Hembusan turun! Siapkan lompatan pendek.';
            windEffect(windDirection);
            playNoise(0.65, 0.045, 'lowpass', 700, 180);
            pulseBoard('#38bdf8', 420);
        }
        const gravityPulse = activeWorld.pulse ? 1 + Math.sin(elapsed * 2.6) * 0.18 : 1;
        const worldSpeed = activeWorld.speed;
        speed = (290 + difficultyLevel * 90 + Math.min((score % scoreStep) * 0.18, 54)) * worldSpeed * (overdriveUntil > elapsed ? 0.62 : 1);
        updateHud();

        if (jumpY > 0 || jumpVelocity > 0) {
            const wasAirborne = jumpY > 0 || jumpVelocity > 0;
            jumpVelocity -= gravity * activeWorld.gravity * gravityPulse * delta;
            if (jumpHeld && jumpVelocity > 0 && jumpHoldTime < maxJumpHold) {
                jumpVelocity += jumpBoost * delta;
                jumpHoldTime += delta;
            }
            if (activeWorld.wind && windUntil > elapsed) jumpVelocity += windDirection * 250 * delta;
            jumpY += jumpVelocity * delta;
            if (jumpY <= 0) {
                jumpY = 0;
                jumpVelocity = 0;
                jumpRotation = 180;
                if (wasAirborne) {
                    landingUntil = elapsed + 0.16;
                    landingEffect();
                }
            }
            if (jumpVelocity > 0) jumpRotation = Math.min(180, jumpRotation + 260 * delta);
        }

        if (landingUntil > elapsed) {
            const squash = (landingUntil - elapsed) / 0.16;
            shapeScaleX = 1 + squash * 0.28;
            shapeScaleY = 1 - squash * 0.34;
        } else if (jumpStartUntil > elapsed) {
            const launch = (jumpStartUntil - elapsed) / 0.1;
            shapeScaleX = 1 + launch * 0.2;
            shapeScaleY = 1 - launch * 0.22;
        } else if (jumpY > 0 && jumpVelocity > 50) {
            shapeScaleX = 0.9;
            shapeScaleY = 1.14;
        } else if (jumpY > 0 && jumpVelocity < -50) {
            shapeScaleX = 1.1;
            shapeScaleY = 0.92;
        } else {
            shapeScaleX = 1;
            shapeScaleY = 1;
        }

        player.style.opacity = invulnerableUntil > elapsed && Math.floor(elapsed * 14) % 2 === 0 ? '0.3' : '1';
        if (dashUntil > elapsed) {
            const dashProgress = Math.min((elapsed - dashStartedAt) / 0.62, 1);
            player.style.transform = `translate(${Math.sin(dashProgress * Math.PI) * 22}px, ${-jumpY}px) rotate(${jumpRotation}deg) scale(${shapeScaleX * 1.35}, ${shapeScaleY})`;
            player.style.boxShadow = '0 0 30px rgba(34,211,238,1), 0 0 60px rgba(34,211,238,.7)';
            if (Math.floor(elapsed * 36) % 3 === 0) {
                const trail = document.createElement('i');
                Object.assign(trail.style, {
                    position: 'absolute', left: `${player.offsetLeft + 2}px`, bottom: `${30 + jumpY + 7}px`,
                    width: '34px', height: '20px', borderRadius: '999px',
                    background: 'linear-gradient(90deg, transparent, rgba(34,211,238,.75))',
                    filter: 'blur(4px)', pointerEvents: 'none', zIndex: '1',
                });
                gameBoard.appendChild(trail);
                const trailAnimation = trail.animate?.([{ opacity: .85, transform: 'scaleX(1)' }, { opacity: 0, transform: 'scaleX(.1)' }], { duration: 280 });
                if (trailAnimation) trailAnimation.onfinish = () => trail.remove();
                window.setTimeout(() => trail.remove(), 300);
            }
        } else {
            player.style.boxShadow = '';
            updatePlayer();
        }

        if (!duelActive) spawnIn -= delta;
        if (!duelActive && spawnIn <= 0) {
            if (waveRemaining === 0 && Math.random() < Math.min(0.07 + difficultyLevel * 0.045, 0.35)) {
                waveRemaining = 1 + Math.floor(Math.random() * (2 + Math.min(difficultyLevel, 2)));
                statusDisplay.textContent = 'Kejutan! Gelombang rintangan datang!';
                playTone(660, 0.16, 0.025, 'square');
                pulseBoard();
            }

            const pickupRoll = Math.random();
            if (waveRemaining === 0 && pickupRoll < 0.12) createSignalShard();
            else if (waveRemaining === 0 && pickupRoll < 0.19) createPowerUp();
            else createObstacle();
            if (waveRemaining > 0) {
                waveRemaining -= 1;
                spawnIn = Math.max(0.72, 0.84 - difficultyLevel * 0.018)
                    + 130 / speed + Math.random() * (45 / speed + 0.05);
            } else {
                const gapTime = Math.max(0.68, 0.86 - difficultyLevel * 0.018) + 170 / speed;
                spawnIn = gapTime + Math.random() * (45 / speed + 0.04);
            }
        }

        const playerRect = player.getBoundingClientRect();
        for (let index = obstacles.length - 1; index >= 0; index -= 1) {
            const obstacle = obstacles[index];
            const nextLeft = obstacle.offsetLeft - speed * delta;
            obstacle.style.left = `${nextLeft}px`;

            if (nextLeft + obstacle.offsetWidth < 0) {
                obstacle.remove();
                obstacles.splice(index, 1);
                continue;
            }

            const obstacleRect = obstacle.getBoundingClientRect();
            const hit = playerRect.right > obstacleRect.left + 5
                && playerRect.left < obstacleRect.right - 5
                && playerRect.bottom > obstacleRect.top + 5
                && playerRect.top < obstacleRect.bottom - 3;

            if (hit) {
                obstacle.remove();
                obstacles.splice(index, 1);
                if (dashUntil > elapsed) {
                    chargeOverdrive(2);
                    const boardBounds = gameBoard.getBoundingClientRect();
                    burst(obstacleRect.left - boardBounds.left + obstacleRect.width / 2, obstacleRect.top - boardBounds.top + obstacleRect.height / 2, '#22d3ee', 14);
                    playTone(760, 0.12, 0.04, 'square');
                    continue;
                }
                if (elapsed < invulnerableUntil) continue;

                if (shieldCharges > 0) {
                    shieldCharges -= 1;
                    statusDisplay.textContent = 'Perisai menyerap tabrakan!';
                    playTone(520, 0.2, 0.05, 'sine');
                } else {
                    hp = Math.max(0, hp - 1);
                    overdriveCharge = Math.max(0, overdriveCharge - 18);
                    combo = 1;
                    comboExpires = 0;
                    statusDisplay.textContent = `Terkena rintangan! Sisa HP ${hp}.`;
                    playTone(180, 0.22, 0.06, 'sawtooth');
                }

                invulnerableUntil = elapsed + 1.1;
                updateHud();
                burst(player.offsetLeft + player.offsetWidth / 2, gameBoard.clientHeight - (30 + jumpY + player.offsetHeight / 2), '#fb7185', 18);
                pulseBoard('#fb7185', 400);
                screenShake(8, 300);
                if (hp <= 0) {
                    finishGame();
                    return;
                }
                continue;
            }
        }

        for (let index = pickups.length - 1; index >= 0; index -= 1) {
            const shard = pickups[index];
            const nextLeft = shard.offsetLeft - speed * delta;
            shard.style.left = `${nextLeft}px`;

            if (nextLeft + shard.offsetWidth < 0) {
                shard.remove();
                pickups.splice(index, 1);
                continue;
            }

            const shardRect = shard.getBoundingClientRect();
            const collected = playerRect.right > shardRect.left
                && playerRect.left < shardRect.right
                && playerRect.bottom > shardRect.top
                && playerRect.top < shardRect.bottom;

            if (collected) {
                const kind = shard.dataset.gamePickup;
                if (kind === 'shield') {
                    shieldCharges = Math.min(shieldCharges + 1, 2);
                    chargeOverdrive(12);
                    statusDisplay.textContent = shieldCharges === 2 ? 'Perisai penuh! Maksimal 2.' : 'Perisai didapat: tahan satu tabrakan.';
                    playTone(620, 0.2, 0.045, 'sine');
                    burst(shard.offsetLeft + 15, gameBoard.clientHeight - shard.offsetTop - 15, '#60a5fa', 16);
                } else if (kind === 'heart' && hp < maxHp) {
                    hp += 1;
                    chargeOverdrive(10);
                    statusDisplay.textContent = `HP pulih! Sisa ${hp}/${maxHp}.`;
                    playTone(740, 0.24, 0.045, 'triangle');
                    burst(shard.offsetLeft + 15, gameBoard.clientHeight - shard.offsetTop - 15, '#fb7185', 16);
                } else {
                    chargeOverdrive(18);
                    combo = elapsed <= comboExpires ? Math.min(combo + 1, 5) : 1;
                    comboExpires = elapsed + 4.2;
                    const shardPoints = 100 * combo * (overdriveUntil > elapsed ? 2 : 1);
                    maxCombo = Math.max(maxCombo, combo);
                    bonusScore += shardPoints;
                    score += shardPoints;
                    scoreDisplay.textContent = score;
                    if (kind !== 'heart') missionProgress += 1;
                    statusDisplay.textContent = kind === 'heart'
                        ? `+${shardPoints}! HP penuh, hati jadi pecahan sinyal.`
                        : `+${shardPoints}! Combo ×${combo} — pecahan sinyal tertangkap.`;
                    playTone(880, 0.18, 0.04, 'triangle');
                    burst(shard.offsetLeft + 11, gameBoard.clientHeight - shard.offsetTop - 11, '#22d3ee', 12);
                    if (kind !== 'heart' && missionProgress >= missionTarget) {
                        missionsCompleted += 1;
                        bonusScore += missionReward;
                        score += missionReward;
                        scoreDisplay.textContent = score;
                        statusDisplay.textContent = `Misi selesai! +${missionReward} poin bonus.`;
                        missionTarget = 3 + Math.floor(Math.random() * 3);
                        missionProgress = 0;
                        missionReward = 250 + difficultyLevel * 50;
                        playTone(990, 0.32, 0.05, 'triangle');
                    }
                }
                shard.remove();
                pickups.splice(index, 1);
                updateHud();
                pulseBoard(kind === 'shield' ? '#60a5fa' : kind === 'heart' ? '#fb7185' : '#22d3ee', 360);
            }
        }

        animationFrame = window.requestAnimationFrame(frame);
    };

    const jumpOrStart = () => {
        if (!playing && !gameOver && !tutorialCompleted) {
            showTutorial();
            return;
        }
        if (paused) return;
        enableAudio();
        if (!playing) {
            summaryOverlay.classList.add('hidden');
            summaryOverlay.classList.remove('flex');
            if (gameOver) {
                obstacles.forEach((obstacle) => obstacle.remove());
                obstacles.length = 0;
                pickups.forEach((pickup) => pickup.remove());
                pickups.length = 0;
            }
            score = 0;
            bonusScore = 0;
            maxCombo = 1;
            missionsCompleted = 0;
            runDuelWins = 0;
            hp = maxHp;
            shieldCharges = 0;
            invulnerableUntil = 0;
            dashUntil = 0;
            dashCooldownUntil = 0;
            overdriveCharge = 0;
            overdriveUntil = 0;
            overdriveAnimation?.cancel();
            overdriveAnimation = null;
            combo = 1;
            comboExpires = 0;
            missionTarget = 3;
            missionProgress = 0;
            missionReward = 250;
            elapsed = 0;
            speed = 290;
            difficultyLevel = 0;
            scoredTime = 0;
            duelActive = false;
            duelExpected = null;
            duelCallout?.classList.add('hidden');
            duelist?.remove();
            duelist = null;
            duelAttacks = 0;
            duelSuccesses = 0;
            nextDuelAt = 24 + Math.random() * 8;
            nextWindAt = elapsed + 6;
            windUntil = 0;
            windDirection = 1;
            applyWorld();
            player.style.filter = '';
            player.style.opacity = '1';
            player.style.boxShadow = '';
            waveRemaining = 0;
            spawnIn = 1.8;
            jumpY = 0;
            jumpVelocity = 0;
            jumpRotation = 0;
            shapeScaleX = 1;
            shapeScaleY = 1;
            landingUntil = 0;
            jumpStartUntil = 0;
            jumpHeld = false;
            jumpHoldTime = 0;
            lastFrame = performance.now();
            scoreDisplay.textContent = '0';
            timeDisplay.textContent = '00:00';
            updateHud();
            updatePlayer();
            playing = true;
            gameOver = false;
            paused = false;
            pauseButton.disabled = false;
            persistentProgress.runs = (persistentProgress.runs || 0) + 1;
            savePersistentProgress();
            actionButton.textContent = 'Lompat';
            statusDisplay.textContent = 'Level 1 — lompat untuk menghindari rintangan!';
            animationFrame = window.requestAnimationFrame(frame);
            return;
        }

        if (jumpY === 0 && jumpVelocity === 0) {
            if (duelActive && duelExpected && !resolveDuelAction('jump')) return;
            jumpVelocity = 620;
            jumpHeld = true;
            jumpHoldTime = 0;
            jumpRotation = 0;
            jumpStartUntil = elapsed + 0.1;
            playNoise(0.28, 0.085, 'bandpass', 320, 1500);
            playTone(360, 0.16, 0.018, 'triangle');
        }
    };

    const handleJumpPointerDown = (event) => {
        if (event.target.closest('[data-game-tutorial-overlay], [data-game-pause-overlay], [data-game-summary-overlay]')) return;
        if (event.currentTarget === gameBoard && event.target.closest('button, input, summary')) return;
        gameBoard.focus({ preventScroll: true });
        jumpOrStart();
    };

    tutorialNext.addEventListener('click', advanceTutorial);
    tutorialSkip.addEventListener('click', () => finishTutorial());
    pauseButton.addEventListener('click', () => togglePause());
    fullscreenButton.addEventListener('click', toggleFullscreen);
    resumeButton.addEventListener('click', () => togglePause(true));
    restartButton.addEventListener('click', () => jumpOrStart());

    const syncVolumeControls = () => {
        musicVolumeInput.value = String(Math.round(musicVolume * 100));
        sfxVolumeInput.value = String(Math.round(sfxVolume * 100));
        musicVolumeLabel.textContent = `${Math.round(musicVolume * 100)}%`;
        sfxVolumeLabel.textContent = `${Math.round(sfxVolume * 100)}%`;
    };
    syncVolumeControls();
    musicVolumeInput.addEventListener('input', () => {
        musicVolume = Number(musicVolumeInput.value) / 100;
        musicVolumeLabel.textContent = `${musicVolumeInput.value}%`;
        try { localStorage.setItem(`${progressKey}-music`, String(musicVolume)); } catch { /* Keep volume for this page session. */ }
    });
    sfxVolumeInput.addEventListener('input', () => {
        sfxVolume = Number(sfxVolumeInput.value) / 100;
        sfxVolumeLabel.textContent = `${sfxVolumeInput.value}%`;
        try { localStorage.setItem(`${progressKey}-sfx`, String(sfxVolume)); } catch { /* Keep volume for this page session. */ }
    });

    gameBoard.addEventListener('pointerdown', handleJumpPointerDown);
    actionButton.addEventListener('pointerdown', handleJumpPointerDown);
    dashButton.addEventListener('click', useDash);
    overdriveButton.addEventListener('click', activateOverdrive);

    window.addEventListener('pointerup', () => {
        jumpHeld = false;
    });
    window.addEventListener('pointercancel', () => {
        jumpHeld = false;
    });

    actionButton.addEventListener('click', (event) => {
        if (event.detail === 0) jumpOrStart();
    });

    musicButton.addEventListener('click', () => {
        musicEnabled = !musicEnabled;
        musicButton.textContent = `Musik: ${musicEnabled ? 'Nyala' : 'Mati'}`;
        musicButton.setAttribute('aria-pressed', String(musicEnabled));
        if (musicEnabled) enableAudio();
        else stopMusic();
    });

    document.addEventListener('keydown', (event) => {
        const gameHasFocus = gameBoard.contains(document.activeElement)
            || document.activeElement === actionButton
            || document.activeElement === dashButton
            || document.activeElement === overdriveButton
            || document.activeElement === pauseButton
            || document.activeElement === fullscreenButton
            || document.activeElement === resumeButton
            || document.activeElement === restartButton;
        if (gameHasFocus && !tutorialOverlay.classList.contains('hidden') && (event.code === 'Enter' || event.code === 'Space')) {
            event.preventDefault();
            advanceTutorial();
            return;
        }
        if (gameHasFocus && (event.code === 'KeyP' || event.code === 'Escape')) {
            event.preventDefault();
            togglePause();
            return;
        }
        if (gameHasFocus && event.code === 'KeyF') {
            event.preventDefault();
            toggleFullscreen();
            return;
        }
        if (gameHasFocus && event.code === 'ShiftLeft') {
            event.preventDefault();
            if (!event.repeat) useDash();
        }
        if (gameHasFocus && event.code === 'KeyX') {
            event.preventDefault();
            if (!event.repeat) activateOverdrive();
        }
        if (gameHasFocus && !paused && (event.code === 'Space' || event.code === 'ArrowUp')) {
            event.preventDefault();
            if (!event.repeat) jumpOrStart();
        }
    });

    document.addEventListener('keyup', (event) => {
        if (event.code === 'Space' || event.code === 'ArrowUp') jumpHeld = false;
    });
}
// Animasi section saat masuk layar
const reduceMotion = window.matchMedia(
    '(prefers-reduced-motion: reduce)'
);

if (!reduceMotion.matches && 'IntersectionObserver' in window) {
    const sectionObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;

            entry.target.animate(
                [
                    { opacity: 0, transform: 'translateY(32px)' },
                    { opacity: 1, transform: 'translateY(0)' }
                ],
                {
                    duration: 750,
                    easing: 'cubic-bezier(0.22, 1, 0.36, 1)'
                }
            );

            observer.unobserve(entry.target);
        });
    }, {
        threshold: 0,
        rootMargin: '0px 0px -40px 0px'
    });

    document.querySelectorAll('main section:not(#hero)').forEach((section) => {
        sectionObserver.observe(section);
    });
}
// Indikator progres scroll pada halaman portofolio
if (document.querySelector('#hero')) {
    const progressBar = document.createElement('div');
    progressBar.className = 'scroll-progress';
    progressBar.setAttribute('aria-hidden', 'true');
    document.body.append(progressBar);

    let progressPending = false;

    const updateProgress = () => {
        const maxScroll =
            document.documentElement.scrollHeight - window.innerHeight;

        const progress = maxScroll > 0
            ? Math.min(1, Math.max(0, window.scrollY / maxScroll))
            : 0;

        progressBar.style.transform = `scaleX(${progress})`;
        progressPending = false;
    };

    const scheduleProgress = () => {
        if (progressPending) return;
        progressPending = true;
        requestAnimationFrame(updateProgress);
    };

    window.addEventListener('scroll', scheduleProgress, { passive: true });
    window.addEventListener('resize', scheduleProgress);
    new ResizeObserver(scheduleProgress).observe(document.body);

    updateProgress();
}
