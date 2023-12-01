export const ACTION_TYPES = {
	RECEIVE_CART: 'RECEIVE_CART',
	RECEIVE_ERROR: 'RECEIVE_ERROR',
	REPLACE_ERRORS: 'REPLACE_ERRORS',
	APPLYING_COUPON: 'APPLYING_COUPON',
	REMOVING_COUPON: 'REMOVING_COUPON',
	RECEIVE_CART_ITEM: 'RECEIVE_CART_ITEM',
	ITEM_PENDING_QUANTITY: 'ITEM_PENDING_QUANTITY',
	SET_IS_CART_DATA_STALE: 'SET_IS_CART_DATA_STALE',
	RECEIVE_REMOVED_ITEM: 'RECEIVE_REMOVED_ITEM',
	UPDATING_CUSTOMER_DATA: 'UPDATING_CUSTOMER_DATA',
	UPDATING_SELECTED_SHIPPING_RATE: 'UPDATING_SELECTED_SHIPPING_RATE',
	UPDATE_LEGACY_CART_FRAGMENTS: 'UPDATE_LEGACY_CART_FRAGMENTS',
} as const;
