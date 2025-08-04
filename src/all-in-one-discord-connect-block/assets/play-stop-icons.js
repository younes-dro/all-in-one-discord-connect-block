import { __ } from '@wordpress/i18n';
import { Icon } from '@wordpress/icons';

export const PlayIcon = () => (
	<Icon
		icon={
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<defs>
					<radialGradient id="playRadial" cx="30%" cy="30%" r="70%">
						<stop offset="0%" stopColor="#34d399" stopOpacity="1" />
						<stop offset="50%" stopColor="#10b981" stopOpacity="1" />
						<stop offset="100%" stopColor="#047857" stopOpacity="0.9" />
					</radialGradient>
					<linearGradient id="playShine" x1="0%" y1="0%" x2="100%" y2="100%">
						<stop offset="0%" stopColor="#ffffff" stopOpacity="0.9" />
						<stop offset="100%" stopColor="#ffffff" stopOpacity="0.1" />
					</linearGradient>
				</defs>

				<circle cx="12" cy="12" r="10" fill="url(#playRadial)" />
				<circle cx="12" cy="12" r="10" fill="url(#playShine)" opacity="0.4" />
				<path d="M9 7 L9 17 L17 12 Z" fill="white" opacity="0.95" />
				<path d="M9 7 L9 17 L17 12 Z" fill="rgba(255,255,255,0.3)" />
			</svg>
		}
	/>
);

export const StopIcon = () => (
	<Icon
		icon={
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<defs>
					<radialGradient id="stopRadial" cx="30%" cy="30%" r="70%">
						<stop offset="0%" stopColor="#f87171" stopOpacity="1" />
						<stop offset="50%" stopColor="#ef4444" stopOpacity="1" />
						<stop offset="100%" stopColor="#b91c1c" stopOpacity="0.9" />
					</radialGradient>
					<linearGradient id="stopShine" x1="0%" y1="0%" x2="100%" y2="100%">
						<stop offset="0%" stopColor="#ffffff" stopOpacity="0.9" />
						<stop offset="100%" stopColor="#ffffff" stopOpacity="0.1" />
					</linearGradient>
				</defs>

				<circle cx="12" cy="12" r="10" fill="url(#stopRadial)" />
				<circle cx="12" cy="12" r="10" fill="url(#stopShine)" opacity="0.4" />
				<rect x="8" y="8" width="8" height="8" rx="1" fill="white" opacity="0.95" />
				<rect x="8" y="8" width="8" height="8" rx="1" fill="rgba(255,255,255,0.3)" />
			</svg>
		}
	/>
);
