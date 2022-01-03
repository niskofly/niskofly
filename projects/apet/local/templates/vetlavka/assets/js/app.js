import initApp from './init';
import initBackendHandlers  from './backend/init';

require('./bootstrap')
require('./helpers')
// require('./dev')

initBackendHandlers();
initApp();
