import Bowser from 'bowser'

const parser = Bowser.getParser(window.navigator.userAgent)

export const browser = parser.getBrowser()
export const os = parser.getOS()
export const platform = parser.getPlatform()
export const engine = parser.getEngine()

export default {
	parser,
	browser,
	os,
	platform,
	engine
}
