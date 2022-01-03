require('./bootstrap')
require('./helpers')

import initApp from './init'
import initBackendHandlers from "./backend/init"

initApp()
initBackendHandlers()
